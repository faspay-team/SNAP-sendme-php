<?php

include __DIR__."/config.php";
include __DIR__."/src/Request.php";

class SendMe extends Request{	
	private $environment = "development";
	
	public function enableProd(){
		$this->environment = "production";
	}
	
	public function accountInquiry($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("accountInquiry");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();
		return $this->getResponseParam();
	}
	
	public function transferInterbank($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("transferInterbank");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();
		return $this->getResponseParam();
	}
	
	public function transferStatus($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("transferStatus");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();
		return $this->getResponseParam();
	}
	
	public function balanceInquiry($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("balanceInquiry");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();
		return $this->getResponseParam();
	}
	
	public function historyList($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("historyList");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();
		return $this->getResponseParam();
	}
	
	public function topupEmoney($data=array()): array
    {
		$this->setEnvironment($this->environment);
		$this->setSection("topupEmoney");
		$this->setRequestParam($data);
		$this->generateHeadersRequest();
		$this->generateUrl();
		$this->curl();		
		return $this->getResponseParam();
	}

    public function emoneyStatus($data=array()): array
    {
        $this->setEnvironment($this->environment);
        $this->setSection("emoneyStatus");
        $this->setRequestParam($data);
        $this->generateHeadersRequest();
        $this->generateUrl();
        $this->curl();
        return $this->getResponseParam();
    }

    public function vaInquiry($data=array()): array
    {
        $this->setEnvironment($this->environment);
        $this->setSection("vaInquiry");
        $this->setRequestParam($data);
        $this->generateHeadersRequest();
        $this->generateUrl();
        $this->curl();
        return $this->getResponseParam();
    }

    public function vaPayment($data=array()): array
    {
        $this->setEnvironment($this->environment);
        $this->setSection("vaPayment");
        $this->setRequestParam($data);
        $this->generateHeadersRequest();
        $this->generateUrl();
        $this->curl();
        return $this->getResponseParam();
    }
}