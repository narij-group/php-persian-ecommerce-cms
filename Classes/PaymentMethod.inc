<?php

require_once 'DataAccess.inc';

class PaymentMethod {

    public $PaymentMethodId;
    public $Name;
    public $Activated;

    public function __construct() {
        $this->PaymentMethodId = 0;
        $this->Name = "";
        $this->Activated = 1;
    }

    public function Insert() {
        $SQL = "Insert Into paymentmethods(Name,Activated) Values ('" . $this->Name . "' , " . $this->Activated . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
//        $SQL = "Update paymentmethods Set `Activated`=" . $this->Activated . " , Name ='" . $this->Name . "' Where PaymentMethodId=" . $this->PaymentMethodId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
    }
    public function SwitchStatus() {
        $SQL = "Update paymentmethods Set `Activated`=" . $this->Activated . " Where PaymentMethodId=" . $this->PaymentMethodId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
//        $SQL = "Delete From paymentmethods Where PaymentMethodId= " . $this->PaymentMethodId;
//        $db = new DataAccess();
//        $db->execute($SQL);
    }

    public function FindOnePaymentMethod() {
        $SQL = "Select * From paymentmethods Where PaymentMethodId=" . $this->PaymentMethodId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
