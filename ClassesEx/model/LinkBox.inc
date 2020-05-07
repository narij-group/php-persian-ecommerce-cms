<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'User.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'LinkboxTitle.inc';

/**
 * Class LinkBox
 */
class LinkBox
{

    /**
     * @var int
     */
    public $LinkBoxId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Link;
    /**
     * @var LinkboxTitle
     */
    public $LinkboxTitle;
    /**
     * @var string
     */
    public $Content;
    /**
     * @var User
     */
    public $User;
    /**
     * @var int
     */
    public $HaveForm;

    /**
     * @return int
     */
    public function getLinkBoxId()
    {
        return $this->LinkBoxId;
    }

    /**
     * @param int $LinkBoxId
     */
    public function setLinkBoxId($LinkBoxId)
    {
        $this->LinkBoxId = $LinkBoxId;
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
     * @return LinkboxTitle
     */
    public function getLinkboxTitle()
    {
        return $this->LinkboxTitle;
    }

    /**
     * @param LinkboxTitle $LinkboxTitle
     */
    public function setLinkboxTitle($LinkboxTitle)
    {
        $this->LinkboxTitle = $LinkboxTitle;
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
     * @return int
     */
    public function getHaveForm()
    {
        return $this->HaveForm;
    }

    /**
     * @param int $HaveForm
     */
    public function setHaveForm($HaveForm)
    {
        $this->HaveForm = $HaveForm;
    }


    /**
     * LinkBox constructor.
     */
    public function __construct()
    {
        $this->LinkBoxId = 0;
        $this->HaveForm = 0;
        $this->Name = "";
        $this->Link = "";
        $this->LinkboxTitle = new LinkboxTitle();
        $this->Content = "";
        $this->User = new User();
    }


}
