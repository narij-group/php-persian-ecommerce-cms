<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .  'User.inc';

/**
 * Class Price
 */
class Price {

    /**
     * @var int
     */
    public $PriceId;
    /**
     * @var int
     */
    public $Product;
    /**
     * @var int
     */
    public $Value;
    /**
     * @var User
     */
    public $User;
    /**
     * @var string
     */
    public $Date;

    /**
     * @return int
     */
    public function getPriceId()
    {
        return $this->PriceId;
    }

    /**
     * @param int $PriceId
     */
    public function setPriceId($PriceId)
    {
        $this->PriceId = $PriceId;
    }

    /**
     * @return int
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param int $Product
     */
    public function setProduct($Product)
    {
        $this->Product = $Product;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param int $Value
     */
    public function setValue($Value)
    {
        $this->Value = $Value;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param User $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    /**
     * Price constructor.
     */
    public function __construct() {
        $this->PriceId = 0;
        $this->Product = 0;
        $this->Value = 0;
        $this->User = new User();
        $this->Date = "";
    }

}
