<?php
namespace Dipnot\PayTR;

/**
 * Class Response
 */
class Response
{
    protected $_config;

    /**
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }
}