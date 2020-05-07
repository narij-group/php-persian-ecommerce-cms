<?php


/**
 * Class Color
 */
class Color {

    /**
     * @var int
     */
    public $ColorId;
    /**
     * @var string
     */
    public $Green;
    /**
     * @var string
     */
    public $DarkBlue;
    /**
     * @var string
     */
    public $LightBlue;

    /**
     * @return int
     */
    public function getColorId()
    {
        return $this->ColorId;
    }

    /**
     * @param int $ColorId
     */
    public function setColorId($ColorId)
    {
        $this->ColorId = $ColorId;
    }

    /**
     * @return string
     */
    public function getGreen()
    {
        return $this->Green;
    }

    /**
     * @param string $Green
     */
    public function setGreen($Green)
    {
        $this->Green = $Green;
    }

    /**
     * @return string
     */
    public function getDarkBlue()
    {
        return $this->DarkBlue;
    }

    /**
     * @param string $DarkBlue
     */
    public function setDarkBlue($DarkBlue)
    {
        $this->DarkBlue = $DarkBlue;
    }

    /**
     * @return string
     */
    public function getLightBlue()
    {
        return $this->LightBlue;
    }

    /**
     * @param string $LightBlue
     */
    public function setLightBlue($LightBlue)
    {
        $this->LightBlue = $LightBlue;
    }

    /**
     * Color constructor.
     */
    public function __construct() {
        $this->ColorId = 0;
        $this->Green = " ";
        $this->DarkBlue = " ";
        $this->LightBlue = " ";        
    }




}
