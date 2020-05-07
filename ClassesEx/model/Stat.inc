<?php


/**
 * Class Stat
 */
class Stat
{
    /**
     * @var int
     */
    public $StatId;
    /**
     * @var string
     */
    public $UserIP;
    /**
     * @var string
     */
    public $Page;
    /**
     * @var int
     */
    public $Visit;
    /**
     * @var false|string
     */
    public $Date;
    /**
     * @var int
     */
    public $Product;

    /**
     * @return int
     */
    public function getStatId()
    {
        return $this->StatId;
    }

    /**
     * @param int $StatId
     */
    public function setStatId($StatId)
    {
        $this->StatId = $StatId;
    }

    /**
     * @return string
     */
    public function getUserIP()
    {
        return $this->UserIP;
    }

    /**
     * @param string $UserIP
     */
    public function setUserIP($UserIP)
    {
        $this->UserIP = $UserIP;
    }

    /**
     * @return string
     */
    public function getPage()
    {
        return $this->Page;
    }

    /**
     * @param string $Page
     */
    public function setPage($Page)
    {
        $this->Page = $Page;
    }

    /**
     * @return int
     */
    public function getVisit()
    {
        return $this->Visit;
    }

    /**
     * @param int $Visit
     */
    public function setVisit($Visit)
    {
        $this->Visit = $Visit;
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
     * Stat constructor.
     */
    public function __construct()
    {
        $this->StatId = 0;
        $this->UserIP = "";
        $this->Page = "";
        $this->Visit = 0;
        date_default_timezone_set("Asia/Tehran");
        $this->Date = date("Y-m-d H:i:s", time());
        $this->Product = 0;
    }


}
