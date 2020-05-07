<?php


/**
 * Class ColorList
 */
class ColorList {

    /**
     * @var int
     */
    public $ColorListId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Sample;

    /**
     * @return int
     */
    public function getColorListId()
    {
        return $this->ColorListId;
    }

    /**
     * @param int $ColorListId
     */
    public function setColorListId($ColorListId)
    {
        $this->ColorListId = $ColorListId;
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
    public function getSample()
    {
        return $this->Sample;
    }

    /**
     * @param string $Sample
     */
    public function setSample($Sample)
    {
        $this->Sample = $Sample;
    }


    /**
     * ColorList constructor.
     */
    public function __construct() {
        $this->ColorListId = 0;        
        $this->Name = "";
        $this->Sample = "";
    }

}
