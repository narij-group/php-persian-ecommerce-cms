<?php


/**
 * Class ProtocolList
 */
class ProtocolList {

    /**
     * @var int
     */
    public $ProtocolListId;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var string
     */
    public $Name;

    /**
     * @return int
     */
    public function getProtocolListId()
    {
        return $this->ProtocolListId;
    }

    /**
     * @param int $ProtocolListId
     */
    public function setProtocolListId($ProtocolListId)
    {
        $this->ProtocolListId = $ProtocolListId;
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
     * ProtocolList constructor.
     */
    public function __construct() {
        $this->ProtocolListId = 0;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
    }


}
