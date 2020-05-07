<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'User.inc';

/**
 * Class Category
 */
class Category
{

    /**
     * @var int
     */
    public $CategoryId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Description;
    /**
     * @var int
     */
    public $Parent;
    /**
     * @var User
     */
    public $User;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->CategoryId = 0;
        $this->Name = "";
        $this->Description = "";
        $this->Parent = 0;
        $this->User = new User();
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->CategoryId;
    }

    /**
     * @param int $CategoryId
     */
    public function setCategoryId($CategoryId)
    {
        $this->CategoryId = $CategoryId;
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
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    /**
     * @return int
     */
    public function getParent()
    {
        return $this->Parent;
    }

    /**
     * @param int $Parent
     */
    public function setParent($Parent)
    {
        $this->Parent = $Parent;
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

}
