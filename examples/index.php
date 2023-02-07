<?php
use Dipnot\PayTR\Model\Buyer;
use Dipnot\PayTR\Model\Currency;
use Dipnot\PayTR\Model\Product;
use Dipnot\PayTR\Request\CreatePaymentFormRequest;

require_once("./../vendor/autoload.php");

// Config
$config = require_once("./_config.php");

// Buyer
$buyer = new Buyer();
$buyer->setEmailAddress("email@address.com");
$buyer->setFullName("Full Name");
$buyer->setAddress("The World");
$buyer->setPhoneNumber("0000000000");
$buyer->setIpAddress("0.0.0.0");

// Products
$product1 = new Product();
$product1->setTitle("Computer");
$product1->setPrice(4000);
$product1->setQuantity(1);

$product2 = new Product();
$product2->setTitle("Phone");
$product2->setPrice(5000);
$product2->setQuantity(2);

// Order ID must be unique for every order and does not contains special characters
$orderId = "UNIQUEORDERCODE" . time();

// Create payment form request and print HTML
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

try {
    $paymentForm = $createPaymentFormRequest->execute();
    $paymentForm->printPaymentForm();
} catch(Exception $e) {
    echo $e->getMessage();
}

// Create hidden order with "$orderId", your logic or someting like that