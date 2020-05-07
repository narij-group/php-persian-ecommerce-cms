<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Customer.inc';

/**
 * Class UserCoupon
 */
class UserCoupon {

    /**
     * @var int
     */
    public $UserCouponId;
    /**
     * @var int
     */
    public $Value;
    /**
     * @var Customer
     */
    public $Customer;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var int
     */
    public $Time;

    /**
     * @return int
     */
    public function getUserCouponId()
    {
        return $this->UserCouponId;
    }

    /**
     * @param int $UserCouponId
     */
    public function setUserCouponId($UserCouponId)
    {
        $this->UserCouponId = $UserCouponId;
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
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @param Customer $Customer
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;
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
    public function getTime()
    {
        return $this->Time;
    }

    /**
     * @param int $Time
     */
    public function setTime($Time)
    {
        $this->Time = $Time;
    }

    /**
     * UserCoupon constructor.
     */
    public function __construct() {
        $this->UserCouponId = 0;
        $this->Value = 0;
        $this->Time = 0;
        $this->Customer = new Customer();
        $this->Date = date("Y/m/d");
    }


}
