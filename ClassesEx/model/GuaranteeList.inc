<?php


/**
 * Class GuaranteeList
 */
class GuaranteeList {

    /**
     * @var int
     */
    public $GuaranteeListId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Duration;
    /**
     * @var null
     */
    public $Price;

    /**
     * @return int
     */
    public function getGuaranteeListId()
    {
        return $this->GuaranteeListId;
    }

    /**
     * @param int $GuaranteeListId
     */
    public function setGuaranteeListId($GuaranteeListId)
    {
        $this->GuaranteeListId = $GuaranteeListId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->Duration;
    }

    /**
     * @param string $Duration
     */
    public function setDuration($Duration)
    {
        $this->Duration = $Duration;
    }

    /**
     * @return null
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param null $Price
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
    }

    /**
     * GuaranteeList constructor.
     */
    public function __construct() {
        $this->GuaranteeListId = 0;        
        $this->Name = "";
        $this->Duration = "";
        $this->Price = NULL;        
    }

}
