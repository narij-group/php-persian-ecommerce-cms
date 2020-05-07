<?php

/**
 * Class User
 */
class User
{
    /**
     * @var int
     */
    public $UserId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var string
     */
    public $Family;
    /**
     * @var string
     */
    public $Password;
    /**
     * @var string
     */
    public $Email;
    /**
     * @var string
     */
    public $Username;
    /**
     * @var int
     */
    public $Activate;
    /**
     * @var
     */
    public $ActiveCode;
    /**
     * @var int
     */
    public $Role;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param int $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
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
    public function getFamily()
    {
        return $this->Family;
    }

    /**
     * @param string $Family
     */
    public function setFamily($Family)
    {
        $this->Family = $Family;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
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
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * @param string $Username
     */
    public function setUsername($Username)
    {
        $this->Username = $Username;
    }

    /**
     * @return int
     */
    public function getActivate()
    {
        return $this->Activate;
    }

    /**
     * @param int $Activate
     */
    public function setActivate($Activate)
    {
        $this->Activate = $Activate;
    }

    /**
     * @return mixed
     */
    public function getActiveCode()
    {
        return $this->ActiveCode;
    }

    /**
     * @param mixed $ActiveCode
     */
    public function setActiveCode($ActiveCode)
    {
        $this->ActiveCode = $ActiveCode;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->Role;
    }

    /**
     * @param int $Role
     */
    public function setRole($Role)
    {
        $this->Role = $Role;
    }


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->UserId = 0;
        $this->Name = "";
        $this->Family = "";
        $this->Email = "";
        $this->Password = "";
        $this->Username = "";
        $this->Activate = 0;
        $this->Role = 0;
    }


}
