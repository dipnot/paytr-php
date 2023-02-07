<?php
namespace Dipnot\PayTR;

/**
 * Class Config
 */
class Config
{
    /**
     * @var string
     */
    private $_merchantId = "";

    /**
     * @var string
     */
    private $_merchantKey = "";

    /**
     * @var string
     */
    private $_merchantSalt = "";

    /**
     * @var bool
     */
    private $_debugMode = true;

    /**
     * @var bool
     */
    private $_testMode = true;

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->_merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->_merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getMerchantKey()
    {
        return $this->_merchantKey;
    }

    /**
     * @param string $merchantKey
     */
    public function setMerchantKey($merchantKey)
    {
        $this->_merchantKey = $merchantKey;
    }

    /**
     * @return string
     */
    public function getMerchantSalt()
    {
        return $this->_merchantSalt;
    }

    /**
     * @param string $merchantSalt
     */
    public function setMerchantSalt($merchantSalt)
    {
        $this->_merchantSalt = $merchantSalt;
    }

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->_debugMode;
    }

    /**
     * @param bool $debugMode
     */
    public function setDebugMode($debugMode)
    {
        $this->_debugMode = $debugMode;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->_testMode;
    }

    /**
     * @param bool $testMode
     */
    public function setTestMode($testMode)
    {
        $this->_testMode = $testMode;
    }

    /**
     * @return bool
     */
    public function isAllSet()
    {
        return $this->getMerchantId() &&
            $this->getMerchantKey() &&
            $this->getMerchantSalt();
    }
}