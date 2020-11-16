<?php
use Dipnot\PayTR\Config;

require_once("./../vendor/autoload.php");

// Must be real even if debug or test mode enabled
$config = new Config();
$config->setMerchantId("TODO");
$config->setMerchantKey("TODO");
$config->setMerchantSalt("TODO");
// $config->setTestMode(false);
// $config->setDebugMode(false);

return $config;