<?php
namespace Dipnot\PayTR;

/**
 * Class Request
 */
class Request
{
    const API_ENDPOINT = "https://www.paytr.com/odeme/api/get-token";

    /**
     * @var Config
     */
    protected $_config;

    /**
     * @var HttpClient
     */
    protected $_client;

    /**
     * @param Config $config
     */
    public function __construct($config)
    {
        $this->_config = $config;
        $this->_client = $this->createHttpClient();
    }

    /**
     * @return HttpClient
     */
    private function createHttpClient()
    {
        return new HttpClient(self::API_ENDPOINT);
    }
}