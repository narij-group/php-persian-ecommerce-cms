<?php


/**
 * Class ShippingMethod
 */
class ShippingMethod {

    /**
     * @var int
     */
    public $ShippingMethodId;
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
     * @var string
     */
    public $Image;
    /**
     * @var
     */
    public $Comment;
    /**
     * @var string
     */
    public $AllowedCities;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param string $Content
     */
    public function setContent($Content)
    {
        $this->Content = $Content;
    }

    /**
     * @return int
     */
    public function getShippingMethodId()
    {
        return $this->ShippingMethodId;
    }

    /**
     * @param int $ShippingMethodId
     */
    public function setShippingMethodId($ShippingMethodId)
    {
        $this->ShippingMethodId = $ShippingMethodId;
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
     * @return mixed
     */
    public function getComment()
    {
        return $this->Comment;
    }

    /**
     * @param mixed $Comment
     */
    public function setComment($Comment)
    {
        $this->Comment = $Comment;
    }

    /**
     * @return string
     */
    public function getAllowedCities()
    {
        return $this->AllowedCities;
    }

    /**
     * @param string $AllowedCities
     */
    public function setAllowedCities($AllowedCities)
    {
        $this->AllowedCities = $AllowedCities;
    }

    /**
     * ShippingMethod constructor.
     */
    public function __construct() {
        $this->ShippingMethodId = 0;
        $this->Name = "";
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Content = "";
        $this->AllowedCities = "";
        $this->Activated = 1;
        $this->Price = NULL;
    }

}
