<?php
namespace Dipnot\PayTR;

/**
 * Class Curl
 */
class Curl
{
	/**
	 * @param string $url
	 * @param array  $options
	 *
	 * @return bool|string
	 */
    public function execute($url, $options)
	{
		$curl = curl_init($url);
		curl_setopt_array($curl, $options);
		return curl_exec($curl);
	}
}