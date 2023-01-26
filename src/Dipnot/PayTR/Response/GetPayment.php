<?php
namespace Dipnot\PayTR\Response;
use Dipnot\PayTR\Exception\InvalidDataException;
use Dipnot\PayTR\Exception\InvalidHashException;
use Dipnot\PayTR\Response;
use Exception;

/**
 * Class GetPayment
 */
class GetPayment extends Response
{
	private $_data;

	/**
	 * @return array
	 */
	function getData()
	{
		return $this->_data;
	}

	/**
	 * @param array $data
	 */
	function setData($data)
	{
		$this->_data = $data;
	}

	/**
	 * @return $this
	 * @throws InvalidDataException
	 * @throws InvalidHashException
	 * @throws Exception
	 */
	function execute()
	{
		$this->checkRequiredData();
		$this->checkStatus();
		$this->checkHash();

		return $this;
	}

	/**
	 * @throws InvalidDataException
	 */
	private function checkRequiredData()
	{
		if(!$this->getData()) {
			throw new InvalidDataException("Data cannot be empty");
		}

		if(!is_array($this->getData())) {
			throw new InvalidDataException("Data must be an array");
		}

		if(!isset($this->getData()["merchant_oid"]) || !$this->getData()["merchant_oid"]) {
			throw new InvalidDataException('"merchant_oid" must be set');
		}

		if(!isset($this->getData()["payment_type"]) || !$this->getData()["payment_type"]) {
			throw new InvalidDataException('"payment_type" must be set');
		}

		if(!isset($this->getData()["status"]) || !$this->getData()["status"]) {
			throw new InvalidDataException('"status" must be set');
		}

		if(!isset($this->getData()["total_amount"]) || !$this->getData()["total_amount"]) {
			throw new InvalidDataException('"total_amount" must be set');
		}

		if(!isset($this->getData()["hash"]) || !$this->getData()["hash"]) {
			throw new InvalidDataException('"hash" must be set');
		}
	}

	/**
	 * @throws Exception
	 */
	private function checkStatus()
	{
		if($this->getData()["status"] !== "success") {
			throw new Exception("The payment transaction failed");
		}
	}

	/**
	 * @throws InvalidHashException
	 */
	private function checkHash()
	{
		$hashHmac = hash_hmac("sha256", $this->getData()["merchant_oid"] . $this->_config->getMerchantSalt() . $this->getData()["status"] . $this->getData()["total_amount"], $this->_config->getMerchantKey(), true);
		$hash = base64_encode($hashHmac);

		if($hash !== $this->getData()["hash"]) {
			throw new InvalidHashException("Invalid hash");
		}
	}
}