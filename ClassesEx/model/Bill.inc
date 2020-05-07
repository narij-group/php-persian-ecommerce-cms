<?php

/**
 * Class Bill
 */
class Bill {

    /**
     * @var int
     */
    public $BillId;
    /**
     * @var string
     */
    public $Comment;
    /**
     * @var string
     */
    public $Code;
    /**
     * @var string
     */
    public $Date;
    /**
     * @var int
     */
    public $TraceCode;
    /**
     * @var int
     */
    public $Status;
    /**
     * @var string
     */
    public $Bank;

    /**
     * @return int
     */
    public function getBillId()
    {
        return $this->BillId;
    }

    /**
     * @param int $BillId
     */
    public function setBillId($BillId)
    {
        $this->BillId = $BillId;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->Comment;
    }

    /**
     * @param string $Comment
     */
    public function setComment($Comment)
    {
        $this->Comment = $Comment;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param string $Code
     */
    public function setCode($Code)
    {
        $this->Code = $Code;
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
    public function getTraceCode()
    {
        return $this->TraceCode;
    }

    /**
     * @param int $TraceCode
     */
    public function setTraceCode($TraceCode)
    {
        $this->TraceCode = $TraceCode;
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
    public function getBank()
    {
        return $this->Bank;
    }

    /**
     * @param string $Bank
     */
    public function setBank($Bank)
    {
        $this->Bank = $Bank;
    }


    /**
     * Bill constructor.
     */
    public function __construct() {
        $this->BillId = 0;
        $this->Comment = "";
        $this->Code = "";
        $this->Date = "";
        $this->TraceCode = 0;
        $this->Status = 0;
        $this->Bank = "";
    }

}
