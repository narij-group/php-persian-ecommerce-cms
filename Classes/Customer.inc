<?php

require_once 'DataAccess.inc';

class Customer {

    public $CustomerId;
    public $Name;
    public $Family;
    public $Username;
    public $Password;
    public $Email;
    public $City;
    public $NationalityCode;
    public $Estate;
    public $Address;
    public $Phone;
    public $Mobile;
    public $PostCode;
    public $IP;
    public $RequestedProducts;

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

    public function Insert() {
        $SQL = "Insert Into customers(`Name`,Family,Email,Username,`Password`,City,NationalityCode,Estate,Address,PostCode,Phone,Mobile) Values('" . $this->Name . "' , '" . $this->Family . "' , '" . $this->Email . "' , '" . $this->Username . "' , '" . $this->Password . "' , '" . $this->City . "' , '" . $this->NationalityCode . "' , '" . $this->Estate . "' , '" . $this->Address . "', '" . $this->PostCode . "', '" . $this->Phone . "', '" . $this->Mobile . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update customers Set `Name`='" . $this->Name . "',Family='" . $this->Family . "',Email='" . $this->Email . "',`Password`='" . $this->Password . "',Username='" . $this->Username . "',City='" . $this->City . "' , NationalityCode='" . $this->NationalityCode . "' , Estate= '" . $this->Estate . "' , Address = '" . $this->Address . "', PostCode = '" . $this->PostCode . "', Mobile = '" . $this->Mobile . "', Phone = '" . $this->Phone . "' Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function UpdateLocation() {
        $SQL = "Update customers Set City='" . $this->City . "' , Estate= '" . $this->Estate . "' Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $db->execute($SQL);
    }
    
    public function UpdateIP(){
        $SQL = "Update customers Set IP = '" . $this->IP . "' Where CustomerId=" . $this->CustomerId;        
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function UpdateRequests(){
        $SQL = "Update customers Set RequestedProducts = '" . $this->RequestedProducts . "' Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function UpdateSRequests(){
        $SQL = "Update customers Set SRequestedProducts = '" . $this->SRequestedProducts . "' Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From customers Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneCustomer() {
        $SQL = "Select * From customers Where CustomerId=" . $this->CustomerId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->CustomerId = $row['CustomerId'];
            $customer->Name = $row['Name'];
            $customer->Family = $row['Family'];
            $customer->Email = $row['Email'];
            $customer->Username = $row['Username'];
            $customer->Password = $row['Password'];
            $customer->City = $row['City'];
            $customer->NationalityCode = $row['NationalityCode'];
            $customer->Address = $row['Address'];
            $customer->Estate = $row['Estate'];
            $customer->Phone = $row['Phone'];
            $customer->Mobile = $row['Mobile'];
            $customer->PostCode = $row['PostCode'];
            $customer->IP = $row['IP'];
            $customer->RequestedProducts = $row['RequestedProducts'];
            $customer->SRequestedProducts = $row['SRequestedProducts'];
            return $customer;
        }
    }

    public function Fill() {
        $SQL = "Select * From customers ORDER BY CustomerId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $customers = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->CustomerId = $row['CustomerId'];
            $customer->Name = $row['Name'];
            $customer->Family = $row['Family'];
            $customer->Email = $row['Email'];
            $customer->Username = $row['Username'];
            $customer->Password = $row['Password'];
            $customer->City = $row['City'];
            $customer->NationalityCode = $row['NationalityCode'];
            $customer->Address = $row['Address'];
            $customer->Estate = $row['Estate'];
            $customer->Phone = $row['Phone'];
            $customer->Mobile = $row['Mobile'];
            $customer->PostCode = $row['PostCode'];
            $customer->IP = $row['IP'];
            $customer->RequestedProducts = $row['RequestedProducts'];
            $customer->SRequestedProducts = $row['SRequestedProducts'];
            $customers[$i] = $customer;
            $i++;
        }
        return $customers;
    }
    
    public function IsCustomerAllowed() {
        $SQL = "Select * From customers Where (Email='" . $this->Email . "' OR Username='" . $this->Username . "') And Password='" . $this->Password . "'";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function IsUsernameAllowed() {
        $SQL = "Select * From customers Where Username = '$this->Username'";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function IsNCodeAllowed() {
        $SQL = "Select * From customers Where NationalityCode = '$this->NationalityCode'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function IsEmailAllowed() {
        $SQL = "Select * From customers Where Email = '$this->Email'";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function FindOneCustomerWithEmail() {
        $SQL = "Select * From customers Where Email='" . $this->Email . "' OR Username='" . $this->Username . "'";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $customer = new Customer();
            $customer->CustomerId = $row['CustomerId'];
            $customer->Name = $row['Name'];
            $customer->Family = $row['Family'];
            $customer->Email = $row['Email'];
            $customer->Username = $row['Username'];
            $customer->Password = $row['Password'];
            $customer->City = $row['City'];
            $customer->NationalityCode = $row['NationalityCode'];
            $customer->Address = $row['Address'];
            $customer->Estate = $row['Estate'];
            $customer->Phone = $row['Phone'];
            $customer->Mobile = $row['Mobile'];
            $customer->PostCode = $row['PostCode'];
            $customer->IP = $row['IP'];
            $customer->RequestedProducts = $row['RequestedProducts'];
            $customer->SRequestedProducts = $row['SRequestedProducts'];
            return $customer;
        }
    }
    
    public function FindOneCustomerWithNCode($code) {
        $SQL = "Select * From customers Where NationalityCode='" . $code . "' Limit 1 ";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['CustomerId'];            
        }
    }
    
    public function get_client_ip() {
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
