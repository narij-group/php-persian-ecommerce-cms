<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Customer.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class CustomerDataSource
{

    public $da;

    function __construct()
    {
        $this->da = new DataAccessEx();
    }

    public function open()
    {
        $this->da->open();
    }

    public function close()
    {
        $this->da->close();
    }

    public function Insert(Customer $customer)
    {
        $SQL = "Insert Into customers(`Name`,Family,Email,Username,`Password`,City,NationalityCode,Estate,Address,PostCode,Phone,Mobile) Values('" . $customer->getName() . "' , '" . $customer->getFamily() . "' , '" . $customer->getEmail() . "' , '" . $customer->getUsername() . "' , '" . $customer->getPassword() . "' , '" . $customer->getCity() . "' , '" . $customer->getNationalityCode() . "' , '" . $customer->getEstate() . "' , '" . $customer->getAddress() . "', '" . $customer->getPostCode() . "', '" . $customer->getPhone() . "', '" . $customer->getMobile() . "')";
        $this->da->exec($SQL);
    }

    public function Update(Customer $customer)
    {
        $SQL = "Update customers Set `Name`='" . $customer->getName() . "',Family='" . $customer->getFamily() . "',Email='" . $customer->getEmail() . "',`Password`='" . $customer->getPassword() . "',Username='" . $customer->getUsername() . "',City='" . $customer->getCity() . "' , NationalityCode='" . $customer->getNationalityCode() . "' , Estate= '" . $customer->getEstate() . "' , Address = '" . $customer->getAddress() . "', PostCode = '" . $customer->getPostCode() . "', Mobile = '" . $customer->getMobile() . "', Phone = '" . $customer->getPhone() . "' Where CustomerId=" . $customer->getCustomerId();
        $this->da->exec($SQL);
    }

    public function UpdateLocation(Customer $customer)
    {
        $SQL = "Update customers Set City='" . $customer->getCity() . "' , Estate= '" . $customer->getEstate() . "' Where CustomerId=" . $customer->getCustomerId();
        $this->da->exec($SQL);
    }

    public function UpdateIP(Customer $customer)
    {
        $SQL = "Update customers Set IP = '" . $customer->getIP() . "' Where CustomerId=" . $customer->getCustomerId();
        $this->da->exec($SQL);
    }

    public function UpdateRequests(Customer $customer)
    {
        $SQL = "Update customers Set RequestedProducts = '" . $customer->getRequestedProducts() . "' Where CustomerId=" . $customer->getCustomerId();
        $this->da->exec($SQL);
    }

    public function UpdateSRequests(Customer $customer)
    {
        $SQL = "Update customers Set SRequestedProducts = '" . $customer->getSRequestedProducts() . "' Where CustomerId=" . $customer->getCustomerId();
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From customers Where CustomerId=" . $id;
        $this->da->exec($SQL);
    }


    public function K_Delete($id)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'CommentDataSource.inc';
        $cm = new CommentDataSource();
        $cm->open();
        $cm->DeleteCommentsRelatedToCustomer($id);
        $cm->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'OpinionDataSource.inc';
        $o = new OpinionDataSource();
        $o->open();
        $o->DeleteOpinionsRelatedToCustomer($id);
        $o->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'FactorProductDataSource.inc';
        $fp = new FactorProductDataSource();
        $fp->open();
        $fp->DeleteFactorsRelatedToCustomer($id);
        $fp->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'FactorDataSource.inc';
        $f = new FactorDataSource();
        $f->open();
        $f->DeleteFactorsRelatedToCustomer($id);
        $f->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'PurchaseBasketDataSource.inc';
        $p = new PurchaseBasketDataSource();
        $p->open();
        $p->DeletePurchaseBasketsRelatedToCustomer($id);
        $p->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'UserCouponDataSource.inc';
        $u = new UserCouponDataSource();
        $u->open();
        $u->DeleteUserCouponsRelatedToCustomer($id);
        $u->close();

        $SQL = "Delete From customers Where CustomerId=" . $id;
        $this->da->exec($SQL);
    }


    public function FindOneCustomerBasedOnId($id)
    {
        $SQL = "Select * From customers Where CustomerId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->setCustomerId($row['CustomerId']);
            $customer->setName($row['Name']);
            $customer->setFamily($row['Family']);
            $customer->setEmail($row['Email']);
            $customer->setUsername($row['Username']);
            $customer->setPassword($row['Password']);
            $customer->setCity($row['City']);
            $customer->setNationalityCode($row['NationalityCode']);
            $customer->setAddress($row['Address']);
            $customer->setEstate($row['Estate']);
            $customer->setPhone($row['Phone']);
            $customer->setMobile($row['Mobile']);
            $customer->setPostCode($row['PostCode']);
            $customer->setIP($row['IP']);
            $customer->setRequestedProducts($row['RequestedProducts']);
            $customer->setSRequestedProducts($row['SRequestedProducts']);
            return $customer;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From customers ORDER BY CustomerId DESC";
        $results = $this->da->execSelect($SQL);
        $customers = array();
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->setCustomerId($row['CustomerId']);
            $customer->setName($row['Name']);
            $customer->setFamily($row['Family']);
            $customer->setEmail($row['Email']);
            $customer->setUsername($row['Username']);
            $customer->setPassword($row['Password']);
            $customer->setCity($row['City']);
            $customer->setNationalityCode($row['NationalityCode']);
            $customer->setAddress($row['Address']);
            $customer->setEstate($row['Estate']);
            $customer->setPhone($row['Phone']);
            $customer->setMobile($row['Mobile']);
            $customer->setPostCode($row['PostCode']);
            $customer->setIP($row['IP']);
            $customer->setRequestedProducts($row['RequestedProducts']);
            $customer->setSRequestedProducts($row['SRequestedProducts']);
            $customers[] = $customer;
        }
        return $customers;
    }

    public function IsCustomerAllowed(Customer $customer)
    {
        $SQL = "Select * From customers Where (Email='" . $customer->getEmail() . "' OR Username='" . $customer->getUsername() . "') And Password='" . $customer->getPassword() . "'";
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function IsUsernameAllowed($username)
    {
        $SQL = "Select * From customers Where Username = '{$username}'";
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function IsNCodeAllowed($ncode)
    {
        $SQL = "Select * From customers Where NationalityCode = '{$ncode}'";
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function IsEmailAllowed($email)
    {
        $SQL = "Select * From customers Where Email = '{$email}'";
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function FindOneCustomerWithEmail(Customer $customer)
    {
        $SQL = "Select * From customers Where Email='" . $customer->getEmail() . "' OR Username='" . $customer->getUsername() . "'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->setCustomerId($row['CustomerId']);
            $customer->setName($row['Name']);
            $customer->setFamily($row['Family']);
            $customer->setEmail($row['Email']);
            $customer->setUsername($row['Username']);
            $customer->setPassword($row['Password']);
            $customer->setCity($row['City']);
            $customer->setNationalityCode($row['NationalityCode']);
            $customer->setAddress($row['Address']);
            $customer->setEstate($row['Estate']);
            $customer->setPhone($row['Phone']);
            $customer->setMobile($row['Mobile']);
            $customer->setPostCode($row['PostCode']);
            $customer->setIP($row['IP']);
            $customer->setRequestedProducts($row['RequestedProducts']);
            $customer->setSRequestedProducts($row['SRequestedProducts']);
            return $customer;
        }
    }

    public function FindOneCustomerWithNCode($code)
    {
        $SQL = "Select * From customers Where NationalityCode='" . $code . "' Limit 1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['CustomerId'];
        }
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
