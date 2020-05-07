<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'User.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Product.inc';

/**
 * Class ProductCoupon
 */
class ProductCoupon
{

    /**
     * @var int
     */
    public $ProductCouponId;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var int
     */
    public $Value;
    /**
     * @var Product
     */
    public $Product;
    /**
     * @var User
     */
    public $User;

    /**
     * @return int
     */
    public function getProductCouponId()
    {
        return $this->ProductCouponId;
    }

    /**
     * @param int $ProductCouponId
     */
    public function setProductCouponId($ProductCouponId)
    {
        $this->ProductCouponId = $ProductCouponId;
    }

    /**
     * @return false|string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param false|string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
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
     * ProductCoupon constructor.
     */
    public function __construct()
    {
        $this->ProductCouponId = 0;
        $this->Date = date("Y/m/d");
        $this->Value = 0;
        $this->Product = new Product();
        $this->User = new User();
    }

}
