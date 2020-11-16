<?php
namespace Dipnot\PayTR;

/**
 * Class Config
 * @package Dipnot\PayTR
 */
class Config
{
	private $_merchantId = "";
	private $_merchantKey = "";
	private $_merchantSalt = "";
	private $_debugMode = true;
	private $_testMode = true;

	/**
	 * @return string
	 */
	function getMerchantId()
	{
		return $this->_merchantId;
	}

	/**
	 * @param string $merchantId
	 */
	function setMerchantId($merchantId)
	{
		$this->_merchantId = $merchantId;
	}

	/**
	 * @return string
	 */
	function getMerchantKey()
	{
		return $this->_merchantKey;
	}

	/**
	 * @param string $merchantKey
	 */
	function setMerchantKey($merchantKey)
	{
		$this->_merchantKey = $merchantKey;
	}

	/**
	 * @return string
	 */
	function getMerchantSalt()
	{
		return $this->_merchantSalt;
	}

	/**
	 * @param string $merchantSalt
	 */
	function setMerchantSalt($merchantSalt)
	{
		$this->_merchantSalt = $merchantSalt;
	}

	/**
	 * @return bool
	 */
	function isDebugMode()
	{
		return $this->_debugMode;
	}

	/**
	 * @param bool $debugMode
	 */
	function setDebugMode($debugMode)
	{
		$this->_debugMode = $debugMode;
	}

	/**
	 * @return bool
	 */
	function isTestMode()
	{
		return $this->_testMode;
	}

	/**
	 * @param bool $testMode
	 */
	function setTestMode($testMode)
	{
		$this->_testMode = $testMode;
	}

	/**
	 * Helper to check if all required properties are set
	 *
	 * @return bool
	 */
	function isAllSet()
	{
		return $this->getMerchantId() &&
			$this->getMerchantKey() &&
			$this->getMerchantSalt();
	}
}