<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Product
 * @package Dipnot\PayTR\Model
 */
class Product
{
	private $_title = "";
	private $_price = 0;
	private $_quantity = 0;

	/**
	 * @return string
	 */
	function getTitle()
	{
		return $this->_title;
	}

	/**
	 * @param string $title
	 */
	function setTitle($title)
	{
		$this->_title = $title;
	}

	/**
	 * @return float
	 */
	function getPrice()
	{
		return $this->_price;
	}

	/**
	 * Sets the price by rounding
	 *
	 * @param float $price
	 */
	function setPrice($price)
	{
		$this->_price = round($price, 2);
	}

	/**
	 * @return int
	 */
	function getQuantity()
	{
		return $this->_quantity;
	}

	/**
	 * @param int $quantity
	 */
	function setQuantity($quantity)
	{
		$this->_quantity = $quantity;
	}

	/**
	 * Helper to check if all required properties are set
	 *
	 * @return bool
	 */
	function isAllSet()
	{
		return $this->getTitle() &&
			$this->getPrice() &&
			$this->getQuantity();
	}
}