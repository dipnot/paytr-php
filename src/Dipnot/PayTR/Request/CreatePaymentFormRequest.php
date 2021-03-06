<?php
namespace Dipnot\PayTR\Request;
use Dipnot\PayTR\Model\Buyer;
use Dipnot\PayTR\Model\Product;
use Dipnot\PayTR\Request;
use Exception;

/**
 * Class CreatePaymentFormRequest
 * @package Dipnot\PayTR\Request
 */
class CreatePaymentFormRequest extends Request
{
	private $_token;

	private $_currency = "";
	private $_amount = 0;
	private $_orderId = "";
	private $_successUrl = "";
	private $_failedUrl = "";
	private $_products = null;
	private $_timeout = 20;
	private $_buyer = null;
	private $_noInstallment = 0;
	private $_maxInstallment = 0;

	/**
	 * @return string
	 */
	function getCurrency()
	{
		return $this->_currency;
	}

	/**
	 * @param string $currency
	 */
	function setCurrency($currency)
	{
		$this->_currency = $currency;
	}

	/**
	 * @return float
	 */
	function getAmount()
	{
		return $this->_amount;
	}

	/**
	 * Sets the price by multiplying by 100
	 *
	 * @param float $amount
	 */
	function setAmount($amount)
	{
		$this->_amount = round($amount, 2) * 100;
	}

	/**
	 * @return string
	 */
	function getOrderId()
	{
		return $this->_orderId;
	}

	/**
	 * @param string $orderId
	 */
	function setOrderId($orderId)
	{
		$this->_orderId = $orderId;
	}

	/**
	 * @return string
	 */
	function getSuccessUrl()
	{
		return $this->_successUrl;
	}

	/**
	 * @param string $successUrl
	 */
	function setSuccessUrl($successUrl)
	{
		$this->_successUrl = $successUrl;
	}

	/**
	 * @return string
	 */
	function getFailedUrl()
	{
		return $this->_failedUrl;
	}

	/**
	 * @param string $failedUrl
	 */
	function setFailedUrl($failedUrl)
	{
		$this->_failedUrl = $failedUrl;
	}

	/**
	 * @return Product[]
	 */
	function getProducts()
	{
		return $this->_products;
	}

	/**
	 * @param Product $product
	 */
	function addProduct($product)
	{
		$this->_products[] = $product;
	}

	/**
	 * @return int
	 */
	function getTimeout()
	{
		return $this->_timeout;
	}

	/**
	 * @param int $timeout
	 */
	function setTimeout($timeout)
	{
		$this->_timeout = $timeout;
	}

	/**
	 * @return Buyer
	 */
	function getBuyer()
	{
		return $this->_buyer;
	}

	/**
	 * @param Buyer $buyer
	 */
	function setBuyer($buyer)
	{
		$this->_buyer = $buyer;
	}

	/**
	 * @return bool
	 */
	function isNoInstallment()
	{
		return $this->_noInstallment;
	}

	/**
	 * @param bool $noInstallment
	 */
	function setNoInstallment($noInstallment)
	{
		$this->_noInstallment = $noInstallment;
	}

	/**
	 * @return int
	 */
	function getMaxInstallment()
	{
		return $this->_maxInstallment;
	}

	/**
	 * @param int $maxInstallment
	 */
	function setMaxInstallment($maxInstallment)
	{
		$this->_maxInstallment = $maxInstallment;
	}

	/**
	 * Makes request to the API
	 *
	 * @return $this
	 *
	 * @throws Exception
	 */
	function execute()
	{
		// Check if all required properties are set
		if(!$this->getCurrency() || !$this->getBuyer() || !$this->getOrderId() || !$this->getSuccessUrl() || !$this->getFailedUrl() || !$this->getTimeout()) {
			throw new Exception("Currency, Buyer, Order ID, Success URL, Failed URL and Timeout must be set.");
		}

		// Check if all required properties are set for Config
		if(!$this->_config->isAllSet()) {
			throw new Exception("Merchant ID, Merchant Key and Merchant Salt must be set for Config.");
		}

		// Check if all required properties are set for Buyer
		if(!$this->getBuyer()->isAllSet()) {
			throw new Exception("E-Mail Address, Full Name, Address, Phone Number and IP Address must be set for Buyer.");
		}

		// Check if all required properties are set for each Product
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

		// Show error message if status is not succeed
		if($response->status !== "success") {
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
	function printPaymentForm($id = "payTrIframe")
	{
		if(!$this->_token) {
			throw new Exception("Must call execute() before printing the form.");
		}
		?>
		<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
		<iframe src="https://www.paytr.com/odeme/guvenli/<?= $this->_token ?>"
		        id="<?= $id ?>"
		        style="width:100%"></iframe>
		<script>iFrameResize({}, "#<?=$id?>");</script>
		<?php
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