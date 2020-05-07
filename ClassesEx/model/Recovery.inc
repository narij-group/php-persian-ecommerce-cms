<?php


/**
 * Class Recovery
 */
class Recovery
{
    /**
     * @var int
     */
    public $RecoveryId;
    /**
     * @var string
     */
    public $Customer;
    /**
     * @var int
     */
    public $Time;

    /**
     * @return int
     */
    public function getRecoveryId()
    {
        return $this->RecoveryId;
    }

    /**
     * @param int $RecoveryId
     */
    public function setRecoveryId($RecoveryId)
    {
        $this->RecoveryId = $RecoveryId;
    }

    /**
     * @return string
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @param string $Customer
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;
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
     * Recovery constructor.
     */
    public function __construct()
    {
        $this->RecoveryId = 0;
        $this->Customer = "";
        $this->Time = 0;
    }


}
