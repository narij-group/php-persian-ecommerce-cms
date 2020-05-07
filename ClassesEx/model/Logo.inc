<?php

/**
 * Class Logo
 */
class Logo
{

    /**
     * @var int
     */
    public $LogoId;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $LatinName;
    /**
     * @var int
     */
    public $Activated;

    /**
     * @return int
     */
    public function getLogoId()
    {
        return $this->LogoId;
    }

    /**
     * @param int $LogoId
     */
    public function setLogoId($LogoId)
    {
        $this->LogoId = $LogoId;
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
     * Logo constructor.
     */
    public function __construct()
    {
        $this->LogoId = 0;
        $this->Activated = 1;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
        $this->LatinName = "";
    }


}
