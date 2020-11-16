
# PayTR API Wrapper for PHP
[![Latest Stable Version](https://poser.pugx.org/dipnot/paytr-php/v)](https://packagist.org/packages/dipnot/paytr-php) [![Total Downloads](https://poser.pugx.org/dipnot/paytr-php/downloads)](https://packagist.org/packages/dipnot/paytr-php)  
  
Unofficial PHP wrapper for [PayTR API](https://www.paytr.com/entegrasyon)     
  
## Dependencies
- PHP 5.6.36 or higher  
- ext-curl  
- ext-simplexml  
- ext-json  
    

## Installation  
You can install via [Composer](https://getcomposer.org/).  

    composer require dipnot/paytr-php

  ## Usage
You can see the full example in [examples](https://github.com/dipnot/paytr-php/tree/main/examples) folder.
### Config
All actions are needs a Config.

You must set real merchant info even if debug or test mode enabled.
```php
use Dipnot\PayTR\Config;

$config = new Config();  
$config->setMerchantId("TODO");  
$config->setMerchantKey("TODO");  
$config->setMerchantSalt("TODO");
```

### Create payment form
```php
use Dipnot\PayTR\Model\Buyer;  
use Dipnot\PayTR\Model\Currency;  
use Dipnot\PayTR\Model\Product;  
use Dipnot\PayTR\Request\CreatePaymentFormRequest;

$buyer = new Buyer();  
$buyer->setEmailAddress("email@address.com");  
$buyer->setFullName("Full Name");  
$buyer->setAddress("The World");  
$buyer->setPhoneNumber("0000000000");  
$buyer->setIpAddress("0.0.0.0");  
  
$product1 = new Product();  
$product1->setTitle("Computer");  
$product1->setPrice(4000);  
$product1->setQuantity(1);  
  
$product2 = new Product();  
$product2->setTitle("Phone");  
$product2->setPrice(5000);  
$product2->setQuantity(2);  
  
$orderId = "UNIQUEORDERCODE" . time();  
  
$createPaymentFormRequest = new CreatePaymentFormRequest($config);  
$createPaymentFormRequest->setBuyer($buyer);  
$createPaymentFormRequest->setCurrency(Currency::TL);  
$createPaymentFormRequest->setAmount(9000);  
$createPaymentFormRequest->setOrderId($orderId);  
$createPaymentFormRequest->setSuccessUrl("http://localhost/paytr-php/examples/order.php?orderId={$orderId}&status=success");  
$createPaymentFormRequest->setFailedUrl("http://localhost/paytr-php/examples/order.php?orderId={$orderId}&status=failed");  
$createPaymentFormRequest->addProduct($product1);  
$createPaymentFormRequest->addProduct($product2);  
$createPaymentFormRequest->setTimeout(30);  
$createPaymentFormRequest->setNoInstallment(true);  
$createPaymentFormRequest->setMaxInstallment(0);  
$paymentForm = $createPaymentFormRequest->execute();  
$paymentForm->printPaymentForm();
```

### Get payment (Hook)
```php
use Dipnot\PayTR\Response\GetPayment;  
  
$getPayment = new GetPayment($config);  
$getPayment->setData($_POST);  
  
try {  
  $payment = $getPayment->execute();  
  exit("OK");
} catch(Exception $exception) {   
  exit($exception->getMessage());
}
```
    
## License
[![License: MIT](https://img.shields.io/badge/License-MIT-%232fdcff)](https://github.com/dipnot/paytr-php/blob/main/LICENSE)