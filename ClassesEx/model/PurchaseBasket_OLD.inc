<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Customer.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Product.inc';

/**
 * Class PurchaseBasket
 */
class PurchaseBasket_OLD
{

    /**
     * @var int
     */
    public $PurchaseBasketId;
    /**
     * @var Customer
     */
    public $Customer;
    /**
     * @var Product
     */
    public $Product;
    /**
     * @var int
     */
    public $Price;
    /**
     * @var int
     */
    public $Count;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var int
     */
    public $Color;
    /**
     * @var int
     */
    public $Guarantee;



    /**
     * @return string
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * @param string $Session
     */
    public function setSession($Session)
    {
        $this->Session = $Session;
    }


    /**
     * PurchaseBasket constructor.
     */
    public function __construct()
    {
        $this->PurchaseBasketId = 0;
        $this->Customer = new Customer();
        $this->Product = new Product();
        $this->Price = 0;
        $this->Count = 0;
        $this->Color = 0;
        $this->Guarantee = 0;
        $this->Date = date("Y/m/d");
    }

    /**
     * @return int
     */
    public function getPurchaseBasketId()
    {
        return $this->PurchaseBasketId;
    }

    /**
     * @param int $PurchaseBasketId
     */
    public function setPurchaseBasketId($PurchaseBasketId)
    {
        $this->PurchaseBasketId = $PurchaseBasketId;
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
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @param int $Color
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
    }

    /**
     * @return int
     */
    public function getGuarantee()
    {
        return $this->Guarantee;
    }

    /**
     * @param int $Guarantee
     */
    public function setGuarantee($Guarantee)
    {
        $this->Guarantee = $Guarantee;
    }

}
