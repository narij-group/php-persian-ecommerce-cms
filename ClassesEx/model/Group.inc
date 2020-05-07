<?php

/**
 * Class Group
 */
class Group {

    /**
     * @var int
     */
    public $GroupId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $LatinName;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var int
     */
    public $PlaceAsMainCat;

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->GroupId;
    }

    /**
     * @param int $GroupId
     */
    public function setGroupId($GroupId)
    {
        $this->GroupId = $GroupId;
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
     * @return string
     */
    public function getLatinName()
    {
        return $this->LatinName;
    }

    /**
     * @param string $LatinName
     */
    public function setLatinName($LatinName)
    {
        $this->LatinName = $LatinName;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param string $Image
     */
    public function setImage($Image)
    {
        $this->Image = $Image;
    }

    /**
     * @return int
     */
    public function getPlaceAsMainCat()
    {
        return $this->PlaceAsMainCat;
    }

    /**
     * @param int $PlaceAsMainCat
     */
    public function setPlaceAsMainCat($PlaceAsMainCat)
    {
        $this->PlaceAsMainCat = $PlaceAsMainCat;
    }


    /**
     * Group constructor.
     */
    public function __construct() {
        $this->GroupId = 0;
        $this->Name = "";
        $this->LatinName = "";
        $this->Image = "";
        $this->PlaceAsMainCat = 0;
    }

}
