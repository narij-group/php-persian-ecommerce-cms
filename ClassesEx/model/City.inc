<?php

/**
 * Class City
 */
class City {

    /**
     * @var int
     */
    public $CityId;
    /**
     * @var int
     */
    public $Province;
    /**
     * @var string
     */
    public $Name;

    /**
     * @return int
     */
    public function getCityId()
    {
        return $this->CityId;
    }

    /**
     * @param int $CityId
     */
    public function setCityId($CityId)
    {
        $this->CityId = $CityId;
    }

    /**
     * @return int
     */
    public function getProvince()
    {
        return $this->Province;
    }

    /**
     * @param int $Province
     */
    public function setProvince($Province)
    {
        $this->Province = $Province;
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
     * City constructor.
     */
    public function __construct() {
        $this->CityId = 0;
        $this->Name = "";        
        $this->Province = 0;        
    }

}
