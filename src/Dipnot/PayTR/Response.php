<?php
namespace Dipnot\PayTR;

/**
 * Class Response
 */
abstract class Response
{
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }
}