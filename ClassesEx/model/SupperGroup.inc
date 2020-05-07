<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "Group.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "SubGroup.inc";


/**
 * Class SupperGroup
 */
class SupperGroup {

    /**
     * @var int
     */
    public $SupperGroupId;
    /**
     * @var Group
     */
    public $Group;
    /**
     * @var SubGroup
     */
    public $SubGroup;
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
    public function getSupperGroupId()
    {
        return $this->SupperGroupId;
    }

    /**
     * @param int $SupperGroupId
     */
    public function setSupperGroupId($SupperGroupId)
    {
        $this->SupperGroupId = $SupperGroupId;
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
     * @return SubGroup
     */
    public function getSubGroup()
    {
        return $this->SubGroup;
    }

    /**
     * @param SubGroup $SubGroup
     */
    public function setSubGroup($SubGroup)
    {
        $this->SubGroup = $SubGroup;
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
     * SupperGroup constructor.
     */
    public function __construct() {
        $this->SupperGroupId = 0;
        $this->Group = new Group();
        $this->SubGroup = new SubGroup();
        $this->Name = "";
        $this->LatinName = "";
        $this->Image = "";
        $this->PlaceAsMainCat = 0;
    }


}
