[![N|Solid](https://faspay.co.id/docs/sendme/images/sendMe-new.png)](https://docs.faspay.co.id/getting-started/faspay-sendme) 
## Welcome To Faspay SendMe SNAP

This package provides Faspay SendMe SNAP v1.0.0 support for the PHP Language.

## Requirements

The following versions of PHP are supported.

* PHP 5.6 or latest

To use this package, it will be necessary to have a credential. These are referred to as 
* boi
* private key

in the config.php set the partner_id with boi in your email from faspay.

save your private key file in src/crt/{environment} directory with {environment} correspond to what environment you used.

set your private key filename with format app.key

Please contact Administrator Faspay to create the required credentials and set your public key.

## Installation

To install:

```php
include 'sendme/SendMe.php';
```

To config, open file config.php to set your credential:

```sh
nano sendme/config.php;
```

## Usage

### Register Flow

```php
include __DIR__.'/sendme/SendMe.php';

$sendme = new SendMe();	
$reg = $sendme->accountInquiry([	
	"beneficiaryBankCode" 		=> "002",
	"beneficiaryAccountNo" 	        => "888801000157508",
	"partnerReferenceNo" 		=> "2020102900000000000001",
	"additionalInfo" 	        => 
	[
	    "sourceAccount"    => "9920000082"
        ],
]);
```

the parameter refer to Faspay SendMe SNAP [Documentation](https://docs.faspay.co.id/getting-started/snap/snap-disbursement).

### Environment Production
To use environment production must be call this method like as :

```php
include __DIR__.'/sendme/SendMe.php';

$sendme = new SendMe();	
$sendme->enableProd();
```

#### Available Methods

The `Faspay SendMe` provide has the following [method]:

- 'accountInquiry()' is used to obtain the recipient's account information and to minimize the possibility of incorrect transfer destinations.
- 'transferInterbank()'  is used for transfers from the partner's account to the destination account that has been previously registered.
- 'transferStatus()' is used to check the status of transfers.
- 'balanceInquiry()' is used to check the balance of user accounts registered with Faspay SendMe. 
- 'historyList()' is used to check transaction logs/account mutations registered in Faspay SendMe.
- 'topupEmoney()' is used to transfer funds to e-wallets.
- 'emoneyStatus()' is used to check the status of top-up.
- 'vaInquiry()' is used to inquiry the Bill Payment transaction.
- 'vaPayment()' is used to Bill Payment transaction.
