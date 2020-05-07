<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'GuaranteeList.inc';

/**
 * Class Guarantee
 */
class Guarantee
{

    /**
     * @var int
     */
    public $GuaranteeId;
    /**
     * @var int
     */
    public $Product;
    /**
     * @var GuaranteeList
     */
    public $Guarantee;
    /**
     * @var false|string
     */
    public $Date;

    /**
     * Guarantee constructor.
     */
    public function __construct()
    {
        $this->GuaranteeId = 0;
        $this->Product = 0;
        $this->Guarantee = new GuaranteeList();
        $this->Date = date("Y/m/d");
    }

    /**
     * @return int
     */
    public function getGuaranteeId()
    {
        return $this->GuaranteeId;
    }

    /**
     * @param int $GuaranteeId
     */
    public function setGuaranteeId($GuaranteeId)
    {
        $this->GuaranteeId = $GuaranteeId;
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
     * @return GuaranteeList
     */
    public function getGuarantee()
    {
        return $this->Guarantee;
    }

    /**
     * @param GuaranteeList $Guarantee
     */
    public function setGuarantee($Guarantee)
    {
        $this->Guarantee = $Guarantee;
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


}
