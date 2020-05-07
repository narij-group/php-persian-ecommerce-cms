<?php
date_default_timezone_set("Asia/Tehran");


/**
 * Class Panel
 */
class Panel
{

    /**
     * @var int
     */
    public $PanelId;
    /**
     * @var int
     */
    public $Name;
    /**
     * @var string
     */
    public $Mobile;
    /**
     * @var string
     */
    public $Email;
    /**
     * @var string
     */
    public $Content;
    /**
     * @var string
     */
    public $Date;

    /**
     * @return int
     */
    public function getPanelId()
    {
        return $this->PanelId;
    }

    /**
     * @param int $PanelId
     */
    public function setPanelId($PanelId)
    {
        $this->PanelId = $PanelId;
    }

    /**
     * @return int
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param Group $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->Mobile;
    }

    /**
     * @param string $Mobile
     */
    public function setMobile($Mobile)
    {
        $this->Mobile = $Mobile;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

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
     * @return string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }


    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->PanelId = 0;
        $this->Name = "";
        $this->Mobile = "";
        $this->Email = "";
        $this->Content = "";
        $this->Date = "";
    }

}
