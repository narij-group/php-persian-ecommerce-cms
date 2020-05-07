<?php

/**
 * Class Customer
 */
class Customer {

    /**
     * @var int
     */
    public $CustomerId;
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
    public $Username;
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
    public $City;
    /**
     * @var string
     */
    public $NationalityCode;
    /**
     * @var string
     */
    public $Estate;
    /**
     * @var string
     */
    public $Address;
    /**
     * @var string
     */
    public $Phone;
    /**
     * @var string
     */
    public $Mobile;
    /**
     * @var string
     */
    public $PostCode;
    /**
     * @var string
     */
    public $IP;
    /**
     * @var string
     */
    public $RequestedProducts;

    /**
     * @return string
     */
    public function getSRequestedProducts()
    {
        return $this->SRequestedProducts;
    }

    /**
     * @param string $SRequestedProducts
     */
    public function setSRequestedProducts($SRequestedProducts)
    {
        $this->SRequestedProducts = $SRequestedProducts;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->CustomerId;
    }

    /**
     * @param int $CustomerId
     */
    public function setCustomerId($CustomerId)
    {
        $this->CustomerId = $CustomerId;
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
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getNationalityCode()
    {
        return $this->NationalityCode;
    }

    /**
     * @param string $NationalityCode
     */
    public function setNationalityCode($NationalityCode)
    {
        $this->NationalityCode = $NationalityCode;
    }

    /**
     * @return string
     */
    public function getEstate()
    {
        return $this->Estate;
    }

    /**
     * @param string $Estate
     */
    public function setEstate($Estate)
    {
        $this->Estate = $Estate;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param string $Address
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @param string $Phone
     */
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
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
    public function getPostCode()
    {
        return $this->PostCode;
    }

    /**
     * @param string $PostCode
     */
    public function setPostCode($PostCode)
    {
        $this->PostCode = $PostCode;
    }

    /**
     * @return string
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param string $IP
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
    }

    /**
     * @return string
     */
    public function getRequestedProducts()
    {
        return $this->RequestedProducts;
    }

    /**
     * @param string $RequestedProducts
     */
    public function setRequestedProducts($RequestedProducts)
    {
        $this->RequestedProducts = $RequestedProducts;
    }


    /**
     * Customer constructor.
     */
    public function __construct() {
        $this->CustomerId = 0;
        $this->Name = "";
        $this->Family = "";
        $this->Email = "";
        $this->Username = "";
        $this->Password = "";
        $this->City = "";
        $this->NationalityCode = "";
        $this->Estate = "";
        $this->Address = "";
        $this->Phone = "";
        $this->Mobile = "";
        $this->PostCode = "";
        $this->IP = "";
        $this->RequestedProducts = "";
        $this->SRequestedProducts = "";
    }

}
