<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Customer.inc';

/**
 * Class Opinion
 */
class Opinion {

    /**
     * @var int
     */
    public $OpinionId;
    /**
     * @var Customer
     */
    public $Customer;
    /**
     * @var string
     */
    public $Value;
    /**
     * @var int
     */
    public $ProductId;
    /**
     * @var int
     */
    public $Rate;
    /**
     * @var string
     */
    public $Date;
    /**
     * @var int
     */
    public $Activated;

    /**
     * @return int
     */
    public function getOpinionId()
    {
        return $this->OpinionId;
    }

    /**
     * @param int $OpinionId
     */
    public function setOpinionId($OpinionId)
    {
        $this->OpinionId = $OpinionId;
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
     * @return int
     */
    public function getProductId()
    {
        return $this->ProductId;
    }

    /**
     * @param int $ProductId
     */
    public function setProductId($ProductId)
    {
        $this->ProductId = $ProductId;
    }

    /**
     * @return int
     */
    public function getRate()
    {
        return $this->Rate;
    }

    /**
     * @param int $Rate
     */
    public function setRate($Rate)
    {
        $this->Rate = $Rate;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    /**
     * @return int
     */
    public function getActivated()
    {
        return $this->Activated;
    }

    /**
     * @param int $Activated
     */
    public function setActivated($Activated)
    {
        $this->Activated = $Activated;
    }


    /**
     * Opinion constructor.
     */
    public function __construct() {
        $this->OpinionId = 0;
        $this->Customer = new Customer();
        $this->Value = "";
        $this->Date = "";
        $this->ProductId = 0;
        $this->Rate = 0;
        $this->Activated = 0;
    }


}
