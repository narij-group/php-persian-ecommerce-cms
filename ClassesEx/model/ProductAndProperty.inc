<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductProperty.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Product.inc';

/**
 * Class ProductAndProperty
 */
class ProductAndProperty
{

    /**
     * @var int
     */
    public $ProductAndPropertyId;
    /**
     * @var int
     */
    public $Product;
    /**
     * @var ProductProperty
     */
    public $ProductProperty;
    /**
     * @var string
     */
    public $Value;

    /**
     * @return int
     */
    public function getProductAndPropertyId()
    {
        return $this->ProductAndPropertyId;
    }

    /**
     * @param int $ProductAndPropertyId
     */
    public function setProductAndPropertyId($ProductAndPropertyId)
    {
        $this->ProductAndPropertyId = $ProductAndPropertyId;
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
     * @return ProductProperty
     */
    public function getProductProperty()
    {
        return $this->ProductProperty;
    }

    /**
     * @param ProductProperty $ProductProperty
     */
    public function setProductProperty($ProductProperty)
    {
        $this->ProductProperty = $ProductProperty;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param string $Value
     */
    public function setValue($Value)
    {
        $this->Value = $Value;
    }

    /**
     * ProductAndProperty constructor.
     */
    public function __construct()
    {
        $this->ProductAndPropertyId = 0;
        $this->Product = 0;
        $this->ProductProperty = new ProductProperty();
        $this->Value = "";
    }

}
