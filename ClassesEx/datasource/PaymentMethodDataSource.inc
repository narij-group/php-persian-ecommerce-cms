<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/PaymentMethod.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class PaymentMethodDataSource {


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

    public function Insert(PaymentMethod $paymentMethod) {
        $SQL = "Insert Into paymentmethods(Name,Activated) Values ('" . $paymentMethod->Name . "' , " . $paymentMethod->Activated . ")";
        $this->da->exec($SQL);
    }

    public function Update(PaymentMethod $paymentMethod) {
//        $SQL = "Update paymentmethods Set `Activated`=" . $this->Activated . " , Name ='" . $this->Name . "' Where PaymentMethodId=" . $this->PaymentMethodId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
    }
    public function SwitchStatus(PaymentMethod $paymentMethod) {
        $SQL = "Update paymentmethods Set `Activated`=" . $paymentMethod->Activated . " Where PaymentMethodId=" . $paymentMethod->PaymentMethodId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
//        $SQL = "Delete From paymentmethods Where PaymentMethodId= " . $this->PaymentMethodId;
//        $db = new DataAccess();
//        $db->execute($SQL);
    }

    public function FindOnePaymentMethodBasedOnId($id) {
        $SQL = "Select * From paymentmethods Where PaymentMethodId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $paymentmethod = new PaymentMethod();
            $paymentmethod->PaymentMethodId = $row['PaymentMethodId'];
            $paymentmethod->Name = $row['Name'];
            $paymentmethod->Activated = $row['Activated'];
            return $paymentmethod;
        }
    }

    public function Fill() {
        $SQL = "Select * FROM paymentmethods ";
        $results = $this->da->execSelect($SQL);
        $paymentmethods = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $paymentmethod = new PaymentMethod();
            $paymentmethod->PaymentMethodId = $row['PaymentMethodId'];
            $paymentmethod->Name = $row['Name'];
            $paymentmethod->Activated = $row['Activated'];
            $paymentmethods[$i] = $paymentmethod;
            $i++;
        }
        return $paymentmethods;
    }

    public function CFill() {
        $SQL = "Select * FROM paymentmethods WHERE Activated = 1";
        $results = $this->da->execSelect($SQL);
        $paymentmethods = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $paymentmethod = new PaymentMethod();
            $paymentmethod->PaymentMethodId = $row['PaymentMethodId'];
            $paymentmethod->Name = $row['Name'];
            $paymentmethod->Activated = $row['Activated'];
            $paymentmethods[$i] = $paymentmethod;
            $i++;
        }
        return $paymentmethods;
    }

}
