<?php

require_once __DIR__ . DIRECTORY_SEPARATOR. 'User.inc';

/**
 * Class News
 */
class News
{

    /**
     * @var int
     */
    public $NewsId;
    /**
     * @var string
     */
    public $Title;
    /**
     * @var string
     */
    public $Content;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var string
     */
    public $Keywords;
    /**
     * @var User
     */
    public $User;
    /**
     * @var string
     */
    public $MetaDescription;
    /**
     * @var int
     */
    public $Status;
    /**
     * @var string
     */
    public $Summary;

    /**
     * @return false|string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param false|string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    /**
     * @return int
     */
    public function getNewsId()
    {
        return $this->NewsId;
    }

    /**
     * @param int $NewsId
     */
    public function setNewsId($NewsId)
    {
        $this->NewsId = $NewsId;
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
    public function getKeywords()
    {
        return $this->Keywords;
    }

    /**
     * @param string $Keywords
     */
    public function setKeywords($Keywords)
    {
        $this->Keywords = $Keywords;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param User $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->MetaDescription;
    }

    /**
     * @param string $MetaDescription
     */
    public function setMetaDescription($MetaDescription)
    {
        $this->MetaDescription = $MetaDescription;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->Summary;
    }

    /**
     * @param string $Summary
     */
    public function setSummary($Summary)
    {
        $this->Summary = $Summary;
    }

    /**
     * News constructor.
     */
    public function __construct()
    {
        $this->Status = 0;
        $this->NewsId = 0;
        $this->Title = "";
        $this->Content = "";
        $this->User = new User();
        $this->Image = "";
        $this->Keywords = "";
        $this->MetaDescription = "";
        $this->Summary = "";
        $this->Date = date('Y/m/d');
    }

}
