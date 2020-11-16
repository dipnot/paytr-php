<?php
namespace Dipnot\PayTR;

/**
 * Class HttpClient
 * @package Dipnot\PayTR
 */
class HttpClient
{
	// const METHOD_GET = "GET";
	const METHOD_POST = "POST";
	// const METHOD_PUT = "PUT";
	// const METHOD_DELETE = "DELETE";

	private $_baseUrl;
	private $_curl;

	/**
	 * HttpClient constructor
	 *
	 * @param string $baseUrl
	 */
	function __construct($baseUrl)
	{
		$this->_baseUrl = $baseUrl;
		$this->_curl = new Curl();
	}

	/**
	 * Makes HTTP GET request
	 *
	 * @param string $uri
	 * @param mixed  $body
	 *
	 * @return mixed
	 */
	/*
	function get($uri, $body)
	{
		return $this->makeHttpRequest(self::METHOD_GET, $uri, $body);
	}
	*/

	/**
	 * Makes HTTP POST request
	 *
	 * @param string $uri
	 * @param mixed  $body
	 *
	 * @return mixed
	 */
	function post($uri, $body)
	{
		return $this->makeHttpRequest(self::METHOD_POST, $uri, $body);
	}

	/**
	 * Makes HTTP DELETE request
	 *
	 * @param string $uri
	 * @param mixed  $body
	 *
	 * @return mixed
	 */
	/*
	function delete($uri, $body)
	{
		return $this->makeHttpRequest(self::METHOD_DELETE, $uri, $body);
	}
	*/

	/**
	 * Makes HTTP PUT request
	 *
	 * @param string $uri
	 * @param mixed  $body
	 *
	 * @return mixed
	 */
	/*
	function put($uri, $body)
	{
		return $this->makeHttpRequest(self::METHOD_PUT, $uri, $body);
	}
	*/

	/**
	 * Makes HTTP request
	 *
	 * @param string $method
	 * @param string $uri
	 * @param mixed  $body
	 *
	 * @return mixed
	 */
	private function makeHttpRequest($method, $uri, $body)
	{
		$response = $this->_curl->execute($this->_baseUrl . $uri, [
			CURLOPT_TIMEOUT => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_FRESH_CONNECT => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_POSTFIELDS => $body
		]);

		return $this->parseResponse($response);
	}

	/**
	 * Parses JSON response
	 *
	 * @param mixed $response
	 *
	 * @return mixed
	 */
	private function parseResponse($response)
	{
		return json_decode($response);
	}
}