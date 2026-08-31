<?php
/*
* Get credential in your inbox mail from email by faspay
* Version 1.0
*/

$param["development"]["host"] 				= "https://sendme-sandbox.faspay.co.id";
// channel_id is a public, non-secret routing identifier assigned by Faspay to this
// integration (SendMe product). It does not authenticate the request and is not a
// credential, so it is intentionally hardcoded per environment rather than sourced
// from env vars/vault. Actual authentication material (signing key, partner_id) is
// kept out of this constant and supplied via key_path / merchant configuration.
$param["development"]["channel_id"] 	    = "88001";
$param["development"]["key_path"] 		    = "/crt/development/app.key";
$param["development"]["partner_id"] 		= "";

$param["production"]["host"] 				= "https://sendme.faspay.co.id";
// See note above: channel_id is Faspay's public channel identifier, not a secret.
$param["production"]["channel_id"] 	        = "88001";
$param["production"]["key_path"] 		    = "/crt/production/app.key";
$param["production"]["partner_id"] 		    = "";

return $param; 