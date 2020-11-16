<?php
namespace Dipnot\PayTR;

/**
 * Class Request
 * @package Dipnot\PayTR
 */
class Request
{
	const API_ENDPOINT = "https://www.paytr.com/odeme/api/get-token";

	protected $_config;
	protected $_client;

	/**
	 * Request constructor
	 *
	 * @param Config $config
	 */
	function __construct(Config $config)
	{
		$this->_config = $config;
		$this->_client = $this->createHttpClient();
	}

	/**
	 * Creates HttpClient based on the test mode
	 *
	 * @return HttpClient
	 */
	private function createHttpClient()
	{
		return new HttpClient(self::API_ENDPOINT);
	}
}