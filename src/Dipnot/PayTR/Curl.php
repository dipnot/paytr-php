<?php
namespace Dipnot\PayTR;

/**
 * Class Curl
 * @package Dipnot\PayTR
 */
class Curl
{
	/**
	 * Creates and executes cURL
	 *
	 * @param string $url
	 * @param array  $options
	 *
	 * @return bool|string
	 */
	function execute($url, $options)
	{
		$curl = curl_init($url);
		curl_setopt_array($curl, $options);
		return curl_exec($curl);
	}
}