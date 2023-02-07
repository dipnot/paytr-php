<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Product
 */
class Product
{
    /**
     * @var string
     */
    private $_title = "";

    /**
     * @var float
     */
    private $_price = 0;

    /**
     * @var int
     */
    private $_quantity = 0;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->_price = round($price, 2);
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
    }

    /**
     * @return bool
     */
    public function isAllSet()
    {
        return $this->getTitle() &&
            $this->getPrice() &&
            $this->getQuantity();
    }
}