<?php


/**
 * Class Search
 */
class Search {

    /**
     * @var int
     */
    public $Product;

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
     * Search constructor.
     */
    public function __construct() {
        $this->Product = 0;
    }


}
