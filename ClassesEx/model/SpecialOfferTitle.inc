<?php

/**
 * Class SpecialOfferTitle
 */
class SpecialOfferTitle
{

    /**
     * @var int
     */
    public $SpecialOfferTitleId;
    /**
     * @var string
     */
    public $Title;
    /**
     * @var int
     */
    public $Activated;

    /**
     * @return int
     */
    public function getSpecialOfferTitleId()
    {
        return $this->SpecialOfferTitleId;
    }

    /**
     * @param int $SpecialOfferTitleId
     */
    public function setSpecialOfferTitleId($SpecialOfferTitleId)
    {
        $this->SpecialOfferTitleId = $SpecialOfferTitleId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param string $Title
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
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
     * SpecialOffer constructor.
     */
    public function __construct()
    {
        $this->SpecialOfferTitleId = 0;
        $this->Title = "";
        $this->Activated = 0;
    }


}
