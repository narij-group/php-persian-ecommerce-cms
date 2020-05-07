<?php


/**
 * Class Service
 */
class Service {

    /**
     * @var int
     */
    public $ServiceId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var int
     */
    public $Activated;
    /**
     * @var null
     */
    public $Price;

    /**
     * @return int
     */
    public function getServiceId()
    {
        return $this->ServiceId;
    }

    /**
     * @param int $ServiceId
     */
    public function setServiceId($ServiceId)
    {
        $this->ServiceId = $ServiceId;
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
     * Service constructor.
     */
    public function __construct() {
        $this->ServiceId = 0;
        $this->Name = "";
        $this->Activated = 1;
        $this->Price = NULL;
    }


}
