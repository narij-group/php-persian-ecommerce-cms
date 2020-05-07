<?php


/**
 * Class Slide
 */
class Slide {

    /**
     * @var int
     */
    public $SlideId;
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
    public $Link;

    /**
     * @return int
     */
    public function getSlideId()
    {
        return $this->SlideId;
    }

    /**
     * @param int $SlideId
     */
    public function setSlideId($SlideId)
    {
        $this->SlideId = $SlideId;
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
    public function getLink()
    {
        return $this->Link;
    }

    /**
     * @param string $Link
     */
    public function setLink($Link)
    {
        $this->Link = $Link;
    }

    /**
     * Slide constructor.
     */
    public function __construct() {
        $this->SlideId = 0;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
        $this->Link = "";
    }


}
