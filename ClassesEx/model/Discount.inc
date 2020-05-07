<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "Product.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "User.inc";

/**
 * Class Discount
 */
class Discount {

    /**
     * @var int
     */
    public $DiscountId;
    /**
     * @var Product
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
     * @var int
     */
    public $SpecialOffer;

    /**
     * @return int
     */
    public function getDiscountId()
    {
        return $this->DiscountId;
    }

    /**
     * @param int $DiscountId
     */
    public function setDiscountId($DiscountId)
    {
        $this->DiscountId = $DiscountId;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param Product $Product
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
     * @return int
     */
    public function getSpecialOffer()
    {
        return $this->SpecialOffer;
    }

    /**
     * @param int $SpecialOffer
     */
    public function setSpecialOffer($SpecialOffer)
    {
        $this->SpecialOffer = $SpecialOffer;
    }


    /**
     * Discount constructor.
     */
    public function __construct() {
        $this->DiscountId = 0;
        $this->Product = new Product();
        $this->Value = 0;
        $this->SpecialOffer = 0;
        $this->User = new User();
    }


}
