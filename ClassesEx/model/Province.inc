<?php


/**
 * Class Province
 */
class Province {

    /**
     * @var int
     */
    public $ProvinceId;
    /**
     * @var string
     */
    public $Name;

    /**
     * @return int
     */
    public function getProvinceId()
    {
        return $this->ProvinceId;
    }

    /**
     * @param int $ProvinceId
     */
    public function setProvinceId($ProvinceId)
    {
        $this->ProvinceId = $ProvinceId;
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
     * Province constructor.
     */
    public function __construct() {
        $this->ProvinceId = 0;
        $this->Name = "";        
    }
    

}
