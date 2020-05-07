<?php
date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Factor.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class FactorDataSource
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

    public function Insert(Factor $factor)
    {
        $SQL = "Insert Into factors(`Customer`,Date,Time) Values (" . $factor->getCustomer() . ",'" . $factor->getDate() . "','" . $factor->getTime() . "')";
        $this->da->exec($SQL);
    }

//    public function Update() {
//        $SQL = "Update factors Set `Customer`=" . $this->Customer . ", Date='".$this->Date."' Where FactorId=" . $this->FactorId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
//    }

    public function Delete($id)
    {
        $SQL = "Delete From factors Where FactorId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteFactorsRelatedToCustomer($customerid)
    {
        $SQL = "Select from factors  Where Customer = " . $customerid;
        $this->da->exec($SQL);
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
        $results = $this->da->execSelect($SQL);
        $factors = array();
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->setFactorId($row['FactorId']);
            $factor->setDate($row['Date']);
            $factor->setTime($row['Time']);
            $factor->getCustomer()->setCustomerId($row['CustomerId']);
            $factor->getCustomer()->setName($row['CustomerName']);
            $factor->getCustomer()->setFamily($row['Family']);
            $factor->getCustomer()->setEmail($row['Email']);
            $factor->getCustomer()->setPassword($row['Password']);
            $factor->getCustomer()->setCity($row['City']);
            $factor->getCustomer()->setNationalityCode($row['NationalityCode']);
            $factor->getCustomer()->setAddress($row['Address']);
            $factor->getCustomer()->setEstate($row['Estate']);
            $factors[] = $factor;
        }
        return $factors;
    }

    public function GetOneCustomerFactors($customerid)
    {
        $SQL = "Select factors.FactorId from factors  Where Customer = " . $customerid . " ORDER BY factors.FactorId DESC";
        $results = $this->da->execSelect($SQL);
        $factors = array();
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->setFactorId($row['FactorId']);
            $factors[] = $factor;
        }
        return $factors;
    }

    public function FindSomeoneFactorId(Factor $factor)
    {
        $SQL = "Select factors.FactorId From factors  Inner Join customers On factors.Customer = customers.CustomerId Where Customer=" . $factor->getCustomer();
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $factor = new Factor();
            $factor->FactorId = $row['FactorId'];
            return $factor->FactorId;
        }
    }

}
