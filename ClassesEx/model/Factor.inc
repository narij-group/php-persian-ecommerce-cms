<?php
date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Customer.inc';

/**
 * Class Factor
 */
class Factor
{

    /**
     * @var int
     */
    public $FactorId;
    /**
     * @var Customer
     */
    public $Customer;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var string
     */
    public $Time;

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
     * Factor constructor.
     */
    public function __construct()
    {
        $this->FactorId = 0;
        $this->Customer = new Customer();
        $this->Date = date("Y/m/d");
        $this->Time = strtoupper(date("h:i a"));
    }


}
