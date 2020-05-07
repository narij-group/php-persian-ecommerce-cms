<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "Group.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "SubGroup.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "SupperGroup.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "Logo.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "User.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "Price.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "Discount.inc";

/**
 * Class Product
 */
class Product implements JsonSerializable
{

    /**
     * @var int
     */
    public $ProductId;
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
    public $Description;
    /**
     * @var User
     */
    public $User;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var string
     */
    public $Keywords;
    /**
     * @var string
     */
    public $MetaDescription;
    /**
     * @var string
     */
    public $Review;
    /**
     * @var Logo
     */
    public $Brand;
    /**
     * @var Group
     */
    public $Group;
    /**
     * @var SubGroup
     */
    public $SubGroup;
    /**
     * @var SupperGroup
     */
    public $SupperGroup;
    /**
     * @var int
     */
    public $Activated;


    /**
     * @var array
     */
    public $Prices;

    /**
     * @var array
     */
    public $Opinions;

    /**
     * @var array
     */
    public $ProductProperties;
    /**
     * @var int
     */
    public $Stock;


    /**
     * @var int
     */
    public $Downloadable;


    /**
     * @var string
     */
    public $DownloadContent;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->ProductId = 0;
        $this->Group = new Group();
        $this->SubGroup = new SubGroup();
        $this->SupperGroup = new SupperGroup();
        $this->Name = "";
        $this->LatinName = "";
        $this->Description = "";
        $this->User = new User();
        $this->Image = "";
        $this->Keywords = "";
        $this->MetaDescription = "";
        $this->Review = "";
        $this->Brand = new Logo();
        $this->Activated = 0;
        $this->Prices = array();
        $this->Opinions = array();
        $this->ProductProperties = array();
        $this->Stock = 0;
        $this->Downloadable = 0;
        $this->DownloadContent = "";
    }

    /**
     * @return string
     */
    public function getDownloadContent()
    {
        return $this->DownloadContent;
    }

    /**
     * @param string $DownloadContent
     */
    public function setDownloadContent($DownloadContent)
    {
        $this->DownloadContent = $DownloadContent;
    }

    /**
     * @return int
     */
    public function getDownloadable()
    {
        return $this->Downloadable;
    }

    /**
     * @param int $Downloadable
     */
    public function setDownloadable($Downloadable)
    {
        $this->Downloadable = $Downloadable;
    }

    /**
     * @return array
     */
    public function getOpinions()
    {
        return $this->Opinions;
    }

    /**
     * @param array $Opinions
     */
    public function setOpinions($Opinions)
    {
        $this->Opinions = $Opinions;
    }

    /**
     * @return array
     */
    public function getProductProperties()
    {
        return $this->ProductProperties;
    }

    /**
     * @param array $ProductProperties
     */
    public function setProductProperties($ProductProperties)
    {
        $this->ProductProperties = $ProductProperties;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->Stock;
    }

    /**
     * @param int $Stock
     */
    public function setStock($Stock)
    {
        $this->Stock = $Stock;
    }

    /**
     * @return array
     */
    public function getPrices()
    {
        return $this->Prices;
    }

    /**
     * @param array $Prices
     */
    public function setPrices($Prices)
    {
        $this->Prices = $Prices;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->ProductId;
    }

    /**
     * @param int $ProductId
     */
    public function setProductId($ProductId)
    {
        $this->ProductId = $ProductId;
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
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param User $User
     */
    public function setUser($User)
    {
        $this->User = $User;
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
     * @return string
     */
    public function getKeywords()
    {
        return $this->Keywords;
    }

    /**
     * @param string $Keywords
     */
    public function setKeywords($Keywords)
    {
        $this->Keywords = $Keywords;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->MetaDescription;
    }

    /**
     * @param string $MetaDescription
     */
    public function setMetaDescription($MetaDescription)
    {
        $this->MetaDescription = $MetaDescription;
    }

    /**
     * @return string
     */
    public function getReview()
    {
        return $this->Review;
    }

    /**
     * @param string $Review
     */
    public function setReview($Review)
    {
        $this->Review = $Review;
    }

    /**
     * @return Logo
     */
    public function getBrand()
    {
        return $this->Brand;
    }

    /**
     * @param Logo $Brand
     */
    public function setBrand($Brand)
    {
        $this->Brand = $Brand;
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
     * @return SupperGroup
     */
    public function getSupperGroup()
    {
        return $this->SupperGroup;
    }

    /**
     * @param SupperGroup $SupperGroup
     */
    public function setSupperGroup($SupperGroup)
    {
        $this->SupperGroup = $SupperGroup;
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
     * @return array
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
        // TODO: Implement jsonSerialize() method.
    }


}
