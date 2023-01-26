<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Product
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
	 * @return bool
	 */
	function isAllSet()
	{
		return $this->getTitle() &&
			$this->getPrice() &&
			$this->getQuantity();
	}
}