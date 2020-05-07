<?php

/**
 * Class Shipping
 */
class Shipping {

    /**
     * @var int
     */
    public $ShippingId;
    /**
     * @var string
     */
    public $City;
    /**
     * @var int
     */
    public $Price;

    /**
     * @return int
     */
    public function getShippingId()
    {
        return $this->ShippingId;
    }

    /**
     * @param int $ShippingId
     */
    public function setShippingId($ShippingId)
    {
        $this->ShippingId = $ShippingId;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param int $Price
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
    }

    /**
     * Shipping constructor.
     */
    public function __construct() {
        $this->ShippingId = 0;
        $this->City = "";
        $this->Price = 0;
    }


}
