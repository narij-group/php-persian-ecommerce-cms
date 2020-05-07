<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProtocolList.inc';

/**
 * Class Protocol
 */
class Protocol
{

    /**
     * @var int
     */
    public $ProtocolId;
    /**
     * @var ProtocolList
     */
    public $ProtocolList;
    /**
     * @var int
     */
    public $Product;

    /**
     * @return int
     */
    public function getProtocolId()
    {
        return $this->ProtocolId;
    }

    /**
     * @param int $ProtocolId
     */
    public function setProtocolId($ProtocolId)
    {
        $this->ProtocolId = $ProtocolId;
    }

    /**
     * @return ProtocolList
     */
    public function getProtocolList()
    {
        return $this->ProtocolList;
    }

    /**
     * @param ProtocolList $ProtocolList
     */
    public function setProtocolList($ProtocolList)
    {
        $this->ProtocolList = $ProtocolList;
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
     * Protocol constructor.
     */
    public function __construct()
    {
        $this->ProtocolId = 0;
        $this->ProtocolList = new ProtocolList();
        $this->Product = 0;
    }


}
