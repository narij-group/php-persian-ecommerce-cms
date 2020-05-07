<?php


/**
 * Class Thumb
 */
class Thumb {

    /**
     * @var int
     */
    public $ThumbId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var string
     */
    public $Link;

    /**
     * @return int
     */
    public function getThumbId()
    {
        return $this->ThumbId;
    }

    /**
     * @param int $ThumbId
     */
    public function setThumbId($ThumbId)
    {
        $this->ThumbId = $ThumbId;
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
     * Thumb constructor.
     */
    public function __construct() {
        $this->ThumbId = 0;
        $this->Name = "";
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Link = "";
    }


}
