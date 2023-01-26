<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Buyer
 */
class Buyer
{
	private $_emailAddress = "";
	private $_fullName = "";
	private $_address = "";
	private $_phoneNumber = "";
	private $_ipAddress = "";

	/**
	 * @return string
	 */
	function getEmailAddress()
	{
		return $this->_emailAddress;
	}

	/**
	 * @param string $emailAddress
	 */
	function setEmailAddress($emailAddress)
	{
		$this->_emailAddress = $emailAddress;
	}

	/**
	 * @return string
	 */
	function getFullName()
	{
		return $this->_fullName;
	}

	/**
	 * @param string $fullName
	 */
	function setFullName($fullName)
	{
		$this->_fullName = $fullName;
	}

	/**
	 * @return string
	 */
	function getAddress()
	{
		return $this->_address;
	}

	/**
	 * @param string $address
	 */
	function setAddress($address)
	{
		$this->_address = $address;
	}

	/**
	 * @return string
	 */
	function getPhoneNumber()
	{
		return $this->_phoneNumber;
	}

	/**
	 * @param string $phoneNumber
	 */
	function setPhoneNumber($phoneNumber)
	{
		$this->_phoneNumber = $phoneNumber;
	}

	/**
	 * @return string
	 */
	function getIpAddress()
	{
		return $this->_ipAddress;
	}

	/**
	 * @param string $ipAddress
	 */
	function setIpAddress($ipAddress)
	{
		$this->_ipAddress = $ipAddress;
	}

	/**
	 * @return bool
	 */
	function isAllSet()
	{
		return $this->getEmailAddress() &&
			$this->getFullName() &&
			$this->getAddress() &&
			$this->getPhoneNumber() &&
			$this->getIpAddress();
	}
}