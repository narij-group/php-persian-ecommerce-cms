<?php

require_once 'DataAccess.inc';

class ShippingMethod {

    public $ShippingMethodId;
    public $Name;
    public $Activated;
    public $Price;
    public $Image;
    public $Comment;
    public $AllowedCities;

    public function __construct() {
        $this->ShippingMethodId = 0;
        $this->Name = "";
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Content = "";
        $this->AllowedCities = "";
        $this->Activated = 1;
        $this->Price = NULL;
    }

    public function Insert() {
        $SQL = "Insert Into shippingmethods(Name,Image,Comment,Activated,Price,AllowedCities) Values ('" . $this->Name . "' ,'" . $this->Image . "' ,'" . $this->Comment . "' , " . $this->Activated . ", " . $this->Price . ", '" . $this->AllowedCities . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update shippingmethods Set `Activated`=" . $this->Activated . ",`Price`=" . $this->Price . " , Name ='" . $this->Name . "', Image ='" . $this->Image . "', AllowedCities ='" . $this->AllowedCities . "', Comment ='" . $this->Comment . "' Where ShippingMethodId=" . $this->ShippingMethodId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From shippingmethods Where ShippingMethodId= " . $this->ShippingMethodId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneShippingMethod() {
        $SQL = "Select * From shippingmethods Where ShippingMethodId=" . $this->ShippingMethodId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $shippingmethod = new ShippingMethod();
            $shippingmethod->ShippingMethodId = $row['ShippingMethodId'];
            $shippingmethod->Name = $row['Name'];
            $shippingmethod->Image = $row['Image'];
            $shippingmethod->Comment = $row['Comment'];
            $shippingmethod->AllowedCities = $row['AllowedCities'];
            $shippingmethod->Activated = $row['Activated'];
            $shippingmethod->Price = $row['Price'];
            return $shippingmethod;
        }
    }

    public function Fill() {
        $SQL = "Select * FROM shippingmethods ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $shippingmethods = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $shippingmethod = new ShippingMethod();
            $shippingmethod->ShippingMethodId = $row['ShippingMethodId'];
            $shippingmethod->Name = $row['Name'];
            $shippingmethod->Image = $row['Image'];
            $shippingmethod->AllowedCities = $row['AllowedCities'];
            $shippingmethod->Comment = $row['Comment'];
            $shippingmethod->Activated = $row['Activated'];
            $shippingmethod->Price = $row['Price'];
            $shippingmethods[$i] = $shippingmethod;
            $i++;
        }
        return $shippingmethods;
    }

    public function CFill() {
        $SQL = "Select * FROM shippingmethods WHERE Activated = 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $shippingmethods = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $shippingmethod = new ShippingMethod();
            $shippingmethod->ShippingMethodId = $row['ShippingMethodId'];
            $shippingmethod->Name = $row['Name'];
            $shippingmethod->Image = $row['Image'];
            $shippingmethod->AllowedCities = $row['AllowedCities'];
            $shippingmethod->Comment = $row['Comment'];
            $shippingmethod->Activated = $row['Activated'];
            $shippingmethod->Price = $row['Price'];
            $shippingmethods[$i] = $shippingmethod;
            $i++;
        }
        return $shippingmethods;
    }

}
