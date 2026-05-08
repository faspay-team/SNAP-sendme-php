<?php

class Http{

	private $headTime 	    = "X-TIMESTAMP";
	private $headSign 	    = "X-SIGNATURE";
	private $headPartner    = "X-PARTNER-ID";
	private $headExt        = "X-EXTERNAL-ID";
	private $headChannel    = "CHANNEL-ID";
	private $headContent     = "Content-Type";
	
	protected $host = [
		"development" => "https://sendme-sandbox.faspay.co.id",
		"production" => "https://sendme.faspay.co.id"
	];
	
	protected $path = [
		"accountInquiry" 		=> '/account/v1.0/account-inquiry-external',
		"transferInterbank" 	=> '/account/v1.0/transfer-interbank',
		"transferStatus" 	    => '/account/v1.0/transfer/status',
		"balanceInquiry" 		=> '/account/v1.0/balance-inquiry',
		"historyList" 	        => '/account/v1.0/transaction-history-list',
		"topupEmoney" 		    => '/account/v1.0/emoney/topup',
		"emoneyStatus" 			=> '/account/v1.0/emoney/topup-status',
		"vaInquiry" 	        => '/account/v1.0/transfer-va/inquiry-intrabank',
        "vaPayment"             => '/account/v1.0/transfer-va/payment-intrabank',
	];
	
	private $env 			= "development";
	private $section		= "";
	protected $url 			= NULL;
	private $current_method	= NULL;
	private $current_path	= NULL;
	private $content_type 	= "application/json";
	private $headers 		= array();
	
	protected $reqd			= array();
	private $reqx			= NULL;
	private $rspd			= array();
	private $rspx			= NULL;
	private $extId          = 0;
	
	protected $info			= array();	
	
	protected function setEnvironment($env){
		$this->env = $this->info["environment"] = $env;
	}
	
	protected function getEnvironment(): string
    {
		return $this->env;
	}
	
	protected function setSection($section){
		$this->section = $this->info["section"] = $section;
	}
	
	protected function getSection(): string
    {
		return $this->section;
	}

	protected function setTimestamp(): string
    {
	    return date("Y-m-d")."T".date("H:i:sP");
    }

	protected function setRequestParam($data=array()){
		$config 			= require(__DIR__ . '/../config.php');
		
		if(isset($config[$this->getEnvironment()]["host"]) && $config[$this->getEnvironment()]["host"]){
			$this->host[$this->getEnvironment()] = $config[$this->getEnvironment()]["host"];
		}
		
		$this->reqd = $this->info["request"]["array"] = $data;
		$this->array2json();
	}
	
	protected function getResponseParam(): array
    {
		$this->json2array();
		return $this->rspd;
	}
	
	protected function setHeaders($valueChannel, $valueTime, $valueSign, $valuePartner){
        $rand = rand(10,99);
        $this->extId = $valuePartner.round(microtime(true) * 1000) . $rand;
		$this->headers = $this->info["headers"] = array(
			$this->headExt.":".$this->extId,
			$this->headTime.":".$valueTime,
			$this->headSign.":".$valueSign,
			$this->headChannel.":".$valueChannel,
            $this->headPartner.":".$valuePartner,
            $this->headContent.":".$this->content_type
		);
	}
	
	protected function getPath(): string
    {
		$this->current_path = $this->path[$this->getSection()];
		return $this->current_path;
	}
	
	protected function generateUrl(){
		if(!$this->env || !$this->section){
			return false;
		}
		$host 					= $this->info["host"] 		= $this->host[$this->env];
		$path 					= $this->info["path"] 		= $this->path[$this->section];
		$this->url 				= $this->info["url"] 		= $host.$path;
		$this->current_method 	= $this->info["method"] 	= "POST";
	}
	
	private function array2json($param = NULL){
		$ack 	= false;
		if(!$param) $param = $this->reqd;

		if(is_array($param)){
			$this->reqx = json_encode($param);
		}
		
		$this->info["request"]["json"] 	= $this->reqx;
	}
	
	private function json2array($param = NULL){
		$ack = false;
		if(!$param) $param = $this->rspx;
		
		if(is_string($param)){			
			$this->rspd = json_decode($param, true);
		}
		
		$this->info["response"]["array"] 	= $this->rspd;
		$this->info["response"]["json"] 	= $this->rspx;
	}
	
	protected function curl(){		
		$header[] = "Accept: ".$this->content_type;
		$header[] = "Content-Type: ".$this->content_type;
		
		if($this->headers){
			$header = array_merge($header, $this->headers);
		}
		
		$this->info["headers"] = $header;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : ""));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_CAINFO, __DIR__."/../faspay.crt");
		
		if ($this->current_method == "POST"){	
			curl_setopt($ch, CURLOPT_POST, true);
		}else{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->current_method);
		}
		
		if($this->reqx){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->reqx);
		}		
		
		$rs = curl_exec($ch);
		
		if(empty($rs)){
			$error = curl_error($ch);
			$rs = json_encode(array("error"=>true, "message"=>$error));
		}
		
		if(strpos($rs, "Internal Server Error")){
			$rs = json_encode(array("error"=>true, "message"=>$rs));
		}
		
		if(strpos($rs, "couldn't connect to host")){
			$rs = json_encode(array("error"=>true, "message"=>$rs));
		}
		
		curl_close($ch);
		
		$this->rspx = $rs;
	}
	
}