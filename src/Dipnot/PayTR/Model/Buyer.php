<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Buyer
 */
class Buyer
{
    /**
     * @var string
     */
    private $_emailAddress = "";

    /**
     * @var string
     */
    private $_fullName = "";

    /**
     * @var string
     */
    private $_address = "";

    /**
     * @var string
     */
    private $_phoneNumber = "";

    /**
     * @var string
     */
    private $_ipAddress = "";

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->_emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->_fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->_address = $address;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->_phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->_ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->_ipAddress = $ipAddress;
    }

    /**
     * @return bool
     */
    public function isAllSet()
    {
        return $this->getEmailAddress() &&
            $this->getFullName() &&
            $this->getAddress() &&
            $this->getPhoneNumber() &&
            $this->getIpAddress();
    }
}