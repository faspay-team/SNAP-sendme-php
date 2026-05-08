<?php
/*
* Get credential in your inbox mail from email by faspay
* Version 1.0
*/

$param["development"]["host"] 				= "https://sendme-sandbox.faspay.co.id";
$param["development"]["channel_id"] 	    = "88001";
$param["development"]["key_path"] 		    = "/crt/development/app.key";
$param["development"]["partner_id"] 		= "";

$param["production"]["host"] 				= "https://sendme.faspay.co.id";
$param["production"]["channel_id"] 	        = "88001";
$param["production"]["key_path"] 		    = "/crt/production/app.key";
$param["production"]["partner_id"] 		    = "";

return $param; 