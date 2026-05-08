<?php
include __DIR__."/Http.php";

class Request extends Http{	
	private $config;
	private $timestamp;
	private $signature;
	private $channelId;
	private $partnerId;
	
	public function __construct(){
		
	}
	
	protected function generateHeadersRequest(){		
		$this->config 			= require(__DIR__ . '/../config.php');
		$this->timestamp 		= $this->setTimestamp();
		$this->channelId 		= $this->config[$this->getEnvironment()]["channel_id"];
		$this->partnerId        = $this->config[$this->getEnvironment()]["partner_id"];
		$this->signature 	    = $this->generateSignature();
		$this->setHeaders($this->channelId, $this->timestamp, $this->signature, $this->partnerId);
	}
	
	private function generateSignature(): string
    {
        $path				= $this->getPath();
        $private		= file_get_contents(__DIR__.$this->config[$this->getEnvironment()]["key_path"], true);
        $tempr = json_encode($this->reqd, JSON_UNESCAPED_SLASHES);
        $post = hash('sha256', $tempr);
        $string = "POST:$path:$post:".$this->timestamp;

        $algo = "SHA256";
        openssl_sign($string, $sign, $private, $algo);
		return base64_encode($sign);
	}
}
