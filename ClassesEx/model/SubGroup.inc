<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "Group.inc";

/**
 * Class SubGroup
 */
class SubGroup
{

    /**
     * @var int
     */
    public $SubGroupId;
    /**
     * @var Group
     */
    public $Group;
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
    public function getSubGroupId()
    {
        return $this->SubGroupId;
    }

    /**
     * @param int $SubGroupId
     */
    public function setSubGroupId($SubGroupId)
    {
        $this->SubGroupId = $SubGroupId;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->Group;
    }

    /**
     * @param Group $Group
     */
    public function setGroup($Group)
    {
        $this->Group = $Group;
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
     * SubGroup constructor.
     */
    public function __construct()
    {
        $this->SubGroupId = 0;
        $this->Group = new Group();
        $this->Name = "";
        $this->LatinName = "";
        $this->Image = "";
        $this->PlaceAsMainCat = 0;
    }

}
