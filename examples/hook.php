<?php
/**
 * Maybe you want to check if IP address belongs to PayTR to prevent unwanted requests for more security
 *
 * Normally, PayTR will POST some data until they gets an "OK" response from us every 1 minute
 * But, we will use GET for testing purpose
 *
 * Example query string: merchant_oid=a&payment_type=b&failed_reason_code=c&failed_reason_msg=d&status=e&total_amount=f&hash=g
 */

use Dipnot\PayTR\Response\GetPayment;

require_once("./../vendor/autoload.php");

// Config
$config = require_once("./_config.php");

$getPayment = new GetPayment($config);
$getPayment->setData($_GET); // We use GET. Use $_POST for production

try {
    $payment = $getPayment->execute();

    // Get order by using "$payment->getData()["merchant_oid"]", send e-mail or someting like that

    exit("OK"); // PayTR needs "OK" to understand if it is success
} catch(Exception $exception) {
    // You can also see this message in PayTR panel if you want to debug
    exit($exception->getMessage());
}