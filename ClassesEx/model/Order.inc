<?php
date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . "SupperGroup.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "Customer.inc";

/**
 * Class Order
 */
class Order
{

    /**
     * @var int
     */
    public $OrderId;
    /**
     * @var int
     */
    public $Customer;
    /**
     * @var string
     */
    public $Content;
    /**
     * @var SupperGroup
     */
    public $SupperGroup;
    /**
     * @var string
     */
    public $File;
    /**
     * @var string
     */
    public $Date;
    /**
     * @var int
     */
    public $Status;
    /**
     * @var string
     */
    public $Replay;

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     * @param int $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
    }

    /**
     * @return int
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @param Group $Customer
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param string $Content
     */
    public function setContent($Content)
    {
        $this->Content = $Content;
    }

    /**
     * @return SupperGroup
     */
    public function getSupperGroup()
    {
        return $this->SupperGroup;
    }

    /**
     * @param string $SupperGroup
     */
    public function setSupperGroup($SupperGroup)
    {
        $this->SupperGroup = $SupperGroup;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->File;
    }

    /**
     * @param string $File
     */
    public function setFile($File)
    {
        $this->File = $File;
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
     * @return string
     */
    public function getReplay()
    {
        return $this->Replay;
    }

    /**
     * @param string $Replay
     */
    public function setReplay($Replay)
    {
        $this->Replay = $Replay;
    }


    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->OrderId = 0;
        $this->Customer = new Customer();
        $this->Content = "";
        $this->SupperGroup = new SupperGroup();
        $this->File = "";
        $this->Date = "";
        $this->Status = 0;
        $this->Replay = "";
    }

}
