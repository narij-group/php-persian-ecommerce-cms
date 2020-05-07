<?php
date_default_timezone_set("Asia/Tehran");

require_once 'DataAccess.inc';
require_once 'Customer.inc';

class Factor
{

    public $FactorId;
    public $Customer;
    public $Date;
    public $Time;

    public function __construct()
    {
        $this->FactorId = 0;
        $this->Customer = new Customer();
        $this->Date = date("Y/m/d");
        $this->Time = strtoupper(date("h:i a"));
    }

    public function Insert()
    {
        $SQL = "Insert Into factors(`Customer`,Date,Time) Values (" . $this->Customer . ",'" . $this->Date . "','" . $this->Time . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

//    public function Update() {
//        $SQL = "Update factors Set `Customer`=" . $this->Customer . ", Date='".$this->Date."' Where FactorId=" . $this->FactorId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
//    }

    public function Delete()
    {
        $SQL = "Delete From factors Where FactorId= " . $this->FactorId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

//    public function FindOneFactor() {
//        $SQL = "Select * From factors Where FactorId=" . $this->FactorId;
//        $db = new DataAccess();
//        $results = $db->executeSelect($SQL);
//        while ($row = mysqli_fetch_array($results)) {
//            $factor = new Factor();
//            $factor->FactorId = $row['FactorId'];
//            $factor->CustomerId = $row['CustomerId'];
//            $factor->Date = $row['Date'];
//            return $factor;
//        }
//    }

    public function Fill()
    {
        $SQL = "Select factors.FactorId , factors.Date , factors.Time,customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From factors  Inner Join customers On factors.Customer = customers.CustomerId ORDER BY factors.FactorId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $factors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->FactorId = $row['FactorId'];
            $factor->Date = $row['Date'];
            $factor->Time = $row['Time'];
            $factor->Customer->CustomerId = $row['CustomerId'];
            $factor->Customer->Name = $row['CustomerName'];
            $factor->Customer->Family = $row['Family'];
            $factor->Customer->Email = $row['Email'];
            $factor->Customer->Password = $row['Password'];
            $factor->Customer->City = $row['City'];
            $factor->Customer->NationalityCode = $row['NationalityCode'];
            $factor->Customer->Address = $row['Address'];
            $factor->Customer->Estate = $row['Estate'];
            $factors[$i] = $factor;
            $i++;
        }
        return $factors;
    }

    public function GetOneCustomerFactors($customerid)
    {
        $SQL = "Select factors.FactorId from factors  Where Customer = " . $customerid . " ORDER BY factors.FactorId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $factors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->FactorId = $row['FactorId'];
            $factors[$i] = $factor;
            $i++;
        }
        return $factors;
    }

    public function FindSomeoneFactorId()
    {
        $SQL = "Select factors.FactorId From factors  Inner Join customers On factors.Customer = customers.CustomerId Where Customer=" . $this->Customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->FactorId = $row['FactorId'];
            return $factor->FactorId;
        }
    }

}
