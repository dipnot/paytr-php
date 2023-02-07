<?php
namespace Dipnot\PayTR\Request;
use Dipnot\PayTR\Model\Buyer;
use Dipnot\PayTR\Model\Currency;
use Dipnot\PayTR\Model\Product;
use Dipnot\PayTR\Request;
use Exception;

/**
 * Class CreatePaymentFormRequest
 */
class CreatePaymentFormRequest extends Request
{
    /**
     * @var string
     */
    private $_token;

    /**
     * @var Currency|string
     */
    private $_currency = "";

    /**
     * @var float
     */
    private $_amount = 0;

    /**
     * @var string
     */
    private $_orderId = "";

    /**
     * @var string
     */
    private $_successUrl = "";

    /**
     * @var string
     */
    private $_failedUrl = "";

    /**
     * @var Product[]
     */
    private $_products = [];

    /**
     * @var int
     */
    private $_timeout = 20;

    /**
     * @var ?Buyer
     */
    private $_buyer = null;

    /**
     * @var int
     */
    private $_noInstallment = 0;

    /**
     * @var int
     */
    private $_maxInstallment = 0;

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = round($amount, 2) * 100;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->_orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->_orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->_successUrl;
    }

    /**
     * @param string $successUrl
     */
    public function setSuccessUrl($successUrl)
    {
        $this->_successUrl = $successUrl;
    }

    /**
     * @return string
     */
    public function getFailedUrl()
    {
        return $this->_failedUrl;
    }

    /**
     * @param string $failedUrl
     */
    public function setFailedUrl($failedUrl)
    {
        $this->_failedUrl = $failedUrl;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->_products;
    }

    /**
     * @param Product $product
     */
    public function addProduct($product)
    {
        $this->_products[] = $product;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
    }

    /**
     * @return ?Buyer
     */
    public function getBuyer()
    {
        return $this->_buyer;
    }

    /**
     * @param Buyer $buyer
     */
    public function setBuyer($buyer)
    {
        $this->_buyer = $buyer;
    }

    /**
     * @return int
     */
    public function isNoInstallment()
    {
        return $this->_noInstallment;
    }

    /**
     * @param bool $noInstallment
     */
    public function setNoInstallment($noInstallment)
    {
        $this->_noInstallment = $noInstallment;
    }

    /**
     * @return int
     */
    public function getMaxInstallment()
    {
        return $this->_maxInstallment;
    }

    /**
     * @param int $maxInstallment
     */
    public function setMaxInstallment($maxInstallment)
    {
        $this->_maxInstallment = $maxInstallment;
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function execute()
    {
        if(!$this->getCurrency() || !$this->getBuyer() || !$this->getOrderId() || !$this->getSuccessUrl() || !$this->getFailedUrl() || !$this->getTimeout()) {
            throw new Exception("Currency, Buyer, Order ID, Success URL, Failed URL and Timeout must be set.");
        }

        if(!$this->_config->isAllSet()) {
            throw new Exception("Merchant ID, Merchant Key and Merchant Salt must be set for Config.");
        }

        if(!$this->getBuyer()->isAllSet()) {
            throw new Exception("E-Mail Address, Full Name, Address, Phone Number and IP Address must be set for Buyer.");
        }

        foreach($this->getProducts() as $product) {
            if(!$product->isAllSet()) {
                throw new Exception("Title, Price and Quantity must set for each Product.");
            }
        }

        $postData = [
            "merchant_id" => $this->_config->getMerchantId(),
            "merchant_key" => $this->_config->getMerchantKey(),
            "merchant_salt" => $this->_config->getMerchantSalt(),
            "currency" => $this->getCurrency(),
            "email" => $this->getBuyer()->getEmailAddress(),
            "user_name" => $this->getBuyer()->getFullName(),
            "user_address" => $this->getBuyer()->getAddress(),
            "user_phone" => $this->getBuyer()->getPhoneNumber(),
            "user_ip" => $this->getBuyer()->getIpAddress(),
            "payment_amount" => $this->getAmount(),
            "merchant_oid" => $this->getOrderId(),
            "merchant_ok_url" => $this->getSuccessUrl(),
            "merchant_fail_url" => $this->getFailedUrl(),
            "user_basket" => $this->generateUserBasket($this->getProducts()),
            "timeout_limit" => $this->getTimeout(),
            "debug_on" => $this->_config->isDebugMode() ? 1 : 0,
            "test_mode" => $this->_config->isTestMode() ? 1 : 0,
            "no_installment" => $this->isNoInstallment() ? 1 : 0,
            "max_installment" => $this->getMaxInstallment()
        ];

        $postData["paytr_token"] = $this->generatePayTrToken($postData);

        $response = $this->_client->post("", $postData);

        if(!isset($response->status) || !$response->status) {
            throw new Exception("The 'status' field is missing or empty in the PayTR response.");
        }

        if($response->status !== "success") {
            if(!isset($response->reason) || !$response->reason) {
                throw new Exception("The 'status' is 'success', but the 'reason' field is missing or empty in the PayTR response.");
            }

            throw new Exception($response->reason);
        }

        $this->_token = $response->token;

        return $this;
    }

    /**
     * Prints HTML payment form with token from the API
     * Must call execute() before printing the form
     *
     * @param string $id
     *
     * @throws Exception
     */
    public function printPaymentForm($id = "payTrIframe")
    {
        echo $this->getPaymentForm($id);
    }

    /**
     * Returns HTML payment form with token from the API
     * Must call execute() before printing the form
     *
     * @param string $id
     *
     * @return string
     *
     * @throws Exception
     */
    public function getPaymentForm($id = "payTrIframe")
    {
        if(!$this->_token) {
            throw new Exception("Must call execute() before printing the form.");
        }

        return '
            <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
            <iframe src="https://www.paytr.com/odeme/guvenli/' . $this->_token . '" id="' . $id . '" style="width:100%"></iframe>
            <script>
                const paymentIframe = document.getElementById("' . $id . '");
                if (paymentIframe) {
                    paymentIframe.addEventListener("load", function () {
                        iFrameResize({}, "#' . $id . '");
                    });
                }
            </script>
        ';
    }

    /**
     * Generates user_basket
     *
     * @param Product[] $products
     *
     * @return string
     */
    private function generateUserBasket($products)
    {
        $userBasket = [];

        foreach($products as $product) {
            $userBasket[] = [$product->getTitle(), $product->getPrice(), $product->getQuantity()];
        }

        return base64_encode(json_encode($userBasket));
    }

    /**
     * Generates paytr_token
     *
     * @param array $postData
     *
     * @return string
     */
    private function generatePayTrToken($postData)
    {
        $hashString = $postData["merchant_id"] .
            $postData["user_ip"] .
            $postData["merchant_oid"] .
            $postData["email"] .
            $postData["payment_amount"] .
            $postData["user_basket"] .
            $postData["no_installment"] .
            $postData["max_installment"] .
            $postData["currency"] .
            $postData["test_mode"];

        $hashHmac = hash_hmac("sha256", $hashString . $postData["merchant_salt"], $postData["merchant_key"], true);

        return base64_encode($hashHmac);
    }
}