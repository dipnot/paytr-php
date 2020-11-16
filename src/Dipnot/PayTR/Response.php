<?php
namespace Dipnot\PayTR;

/**
 * Class Response
 * @package Dipnot\PayTR
 */
class Response
{
	protected $_config;

	/**
	 * Response constructor
	 *
	 * @param Config $config
	 */
	function __construct(Config $config)
	{
		$this->_config = $config;
	}
}