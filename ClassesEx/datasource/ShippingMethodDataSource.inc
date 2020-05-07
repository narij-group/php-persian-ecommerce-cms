<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ShippingMethod.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ShippingMethodDataSource
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

    public function Insert(ShippingMethod $shippingMethod)
    {
        $SQL = "Insert Into shippingmethods(Name,Image,Comment,Activated,Price,AllowedCities) Values ('" . $shippingMethod->Name . "' ,'" . $shippingMethod->Image . "' ,'" . $shippingMethod->Comment . "' , " . $shippingMethod->Activated . ", " . $shippingMethod->Price . ", '" . $shippingMethod->AllowedCities . "')";
        $this->da->exec($SQL);
    }

    public function Update(ShippingMethod $shippingMethod)
    {
        $SQL = "Update shippingmethods Set `Activated`=" . $shippingMethod->Activated . ",`Price`=" . $shippingMethod->Price . " , Name ='" . $shippingMethod->Name . "', Image ='" . $shippingMethod->Image . "', AllowedCities ='" . $shippingMethod->AllowedCities . "', Comment ='" . $shippingMethod->Comment . "' Where ShippingMethodId=" . $shippingMethod->ShippingMethodId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From shippingmethods Where ShippingMethodId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneShippingMethodBasedOnId($id)
    {
        $SQL = "Select * From shippingmethods Where ShippingMethodId=" . $id;
        $results = $this->da->execSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select * FROM shippingmethods ";
        $results = $this->da->execSelect($SQL);
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

    public function CFill()
    {
        $SQL = "Select * FROM shippingmethods WHERE Activated = 1";
        $results = $this->da->execSelect($SQL);
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
