<?php

date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Factor.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Product.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Customer.inc';

/**
 * Class FactorProduct
 */
class FactorProduct
{

    /**
     * @var int
     */
    public $FactorProductId;
    /**
     * @var Factor
     */
    public $Factor;
    /**
     * @var int
     */
    public $FactorId;
    /**
     * @var Product
     */
    public $Product;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var int
     */
    public $Price;
    /**
     * @var int
     */
    public $Count;
    /**
     * @var int
     */
    public $Status;
    /**
     * @var int
     */
    public $PaymentStatus;
    /**
     * @var string
     */
    public $Color;
    /**
     * @var string
     */
    public $Guarantee;
    /**
     * @var int
     */
    public $Coupon;
    /**
     * @var int
     */
    public $TraceCode;
    /**
     * @var string
     */
    public $Time;
    /**
     * @var string
     */
    public $Comment;
    /**
     * @var int
     */
    public $PaymentMethod;
    /**
     * @var string
     */
    public $ShippingMethod;
    /**
     * @var string
     */
    public $Services;
    /**
     * @var string
     */
    public $Authority;
    /**
     * @var string
     */
    public $RefId;
    /**
     * @var int
     */
    public $Amount;

    /**
     * FactorProduct constructor.
     */
    public function __construct()
    {
        $this->FactorProductId = 0;
        $this->FactorId = 0;
        $this->Factor = new Factor();
        $this->Product = new Product();
        $this->Date = date("Y/m/d");
        $this->Price = 0;
        $this->Count = 0;
        $this->Status = 0;
        $this->PaymentStatus = 0;
        $this->Coupon = 0;
        $this->TraceCode = 0;
        $this->PaymentMethod = 0;
        $this->ShippingMethod = "";
        $this->Color = "";
        $this->Guarantee = "";
        $this->Comment = "";
        $this->Services = "";
        $this->Time = strtoupper(date("h:i a"));
        $this->Authority = "";
        $this->RefId = "";
        $this->Amount = 0;
    }

    /**
     * @return int
     */
    public function getFactorProductId()
    {
        return $this->FactorProductId;
    }

    /**
     * @param int $FactorProductId
     */
    public function setFactorProductId($FactorProductId)
    {
        $this->FactorProductId = $FactorProductId;
    }

    /**
     * @return Factor
     */
    public function getFactor()
    {
        return $this->Factor;
    }

    /**
     * @param Factor $Factor
     */
    public function setFactor($Factor)
    {
        $this->Factor = $Factor;
    }

    /**
     * @return int
     */
    public function getFactorId()
    {
        return $this->FactorId;
    }

    /**
     * @param int $FactorId
     */
    public function setFactorId($FactorId)
    {
        $this->FactorId = $FactorId;
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
     * @return int
     */
    public function getCount()
    {
        return $this->Count;
    }

    /**
     * @param int $Count
     */
    public function setCount($Count)
    {
        $this->Count = $Count;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return int
     */
    public function getPaymentStatus()
    {
        return $this->PaymentStatus;
    }

    /**
     * @param int $PaymentStatus
     */
    public function setPaymentStatus($PaymentStatus)
    {
        $this->PaymentStatus = $PaymentStatus;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @param string $Color
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
    }

    /**
     * @return string
     */
    public function getGuarantee()
    {
        return $this->Guarantee;
    }

    /**
     * @param string $Guarantee
     */
    public function setGuarantee($Guarantee)
    {
        $this->Guarantee = $Guarantee;
    }

    /**
     * @return int
     */
    public function getCoupon()
    {
        return $this->Coupon;
    }

    /**
     * @param int $Coupon
     */
    public function setCoupon($Coupon)
    {
        $this->Coupon = $Coupon;
    }

    /**
     * @return int
     */
    public function getTraceCode()
    {
        return $this->TraceCode;
    }

    /**
     * @param int $TraceCode
     */
    public function setTraceCode($TraceCode)
    {
        $this->TraceCode = $TraceCode;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->Time;
    }

    /**
     * @param string $Time
     */
    public function setTime($Time)
    {
        $this->Time = $Time;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->Comment;
    }

    /**
     * @param string $Comment
     */
    public function setComment($Comment)
    {
        $this->Comment = $Comment;
    }

    /**
     * @return int
     */
    public function getPaymentMethod()
    {
        return $this->PaymentMethod;
    }

    /**
     * @param int $PaymentMethod
     */
    public function setPaymentMethod($PaymentMethod)
    {
        $this->PaymentMethod = $PaymentMethod;
    }

    /**
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->ShippingMethod;
    }

    /**
     * @param string $ShippingMethod
     */
    public function setShippingMethod($ShippingMethod)
    {
        $this->ShippingMethod = $ShippingMethod;
    }

    /**
     * @return string
     */
    public function getServices()
    {
        return $this->Services;
    }

    /**
     * @param string $Services
     */
    public function setServices($Services)
    {
        $this->Services = $Services;
    }

    /**
     * @return string
     */
    public function getAuthority()
    {
        return $this->Authority;
    }

    /**
     * @param string $Authority
     */
    public function setAuthority($Authority)
    {
        $this->Authority = $Authority;
    }

    /**
     * @return string
     */
    public function getRefId()
    {
        return $this->RefId;
    }

    /**
     * @param string $RefId
     */
    public function setRefId($RefId)
    {
        $this->RefId = $RefId;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param int $Amount
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
    }


}
