<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .'ColorList.inc';

/**
 * Class ProductColor
 */
class ProductColor
{

    /**
     * @var int
     */
    public $ProductColorId;
    /**
     * @var int
     */
    public $Product;
    /**
     * @var ColorList
     */
    public $Color;
    /**
     * @var int
     */
    public $Quantity;

    /**
     * @return int
     */
    public function getProductColorId()
    {
        return $this->ProductColorId;
    }

    /**
     * @param int $ProductColorId
     */
    public function setProductColorId($ProductColorId)
    {
        $this->ProductColorId = $ProductColorId;
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
     * @return ColorList
     */
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @param ColorList $Color
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * @param int $Quantity
     */
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;
    }

    /**
     * ProductColor constructor.
     */
    public function __construct()
    {
        $this->ProductColorId = 0;
        $this->Product = 0;
        $this->Color = new ColorList();
        $this->Quantity = 0;
    }


}
