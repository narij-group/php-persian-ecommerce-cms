<?php

/**
 * Class LinkboxTitle
 */
class LinkboxTitle {

    /**
     * @var int
     */
    public  $LinkboxTitleId;
    /**
     * @var string
     */
    public $Name;

    /**
     * @return int
     */
    public function getLinkboxTitleId()
    {
        return $this->LinkboxTitleId;
    }

    /**
     * @param int $LinkboxTitleId
     */
    public function setLinkboxTitleId($LinkboxTitleId)
    {
        $this->LinkboxTitleId = $LinkboxTitleId;
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
     * LinkboxTitle constructor.
     */
    public function __construct() {
        $this->LinkboxTitleId = 0;
        $this->Name = "";
    }


}
