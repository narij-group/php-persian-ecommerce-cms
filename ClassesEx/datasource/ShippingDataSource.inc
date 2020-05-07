<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Shipping.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ShippingDataSource {

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

    public function Insert(Shipping $shipping) {
        $SQL = "Insert Into shippings(City,Price) Values ('".$shipping->City."' , " . $shipping->Price . ")";
        $this->da->exec($SQL);
    }

    public function Update(Shipping $shipping) {
        $SQL = "Update shippings Set `Price`=" . $shipping->Price . " Where ShippingId=" . $shipping->ShippingId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From shippings Where ShippingId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneShippingBasedOnId($id) {
        $SQL = "Select * From shippings Where ShippingId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $shipping = new Shipping();
            $shipping->ShippingId = $row['ShippingId'];
            $shipping->City = $row['City'];
            $shipping->Price = $row['Price'];
            return $shipping;
        }
    }
    
    public function FindOneShippingBasedOnProvince($city) {
        $SQL = "Select City,ShippingId,IFNULL(Price,0) as Price From shippings Where City=" . $city;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $shipping = new Shipping();
            $shipping->ShippingId = $row['ShippingId'];
            $shipping->City = $row['City'];
            $shipping->Price = $row['Price'];
            return $shipping;
        }
    }

    public function Fill() {
        $SQL = "Select * FROM shippings ";
        $results = $this->da->execSelect($SQL);
        $shippings = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $shipping = new Shipping();
            $shipping->ShippingId = $row['ShippingId'];
            $shipping->City = $row['City'];
            $shipping->Price = $row['Price'];
            $shippings[$i] = $shipping;
            $i++;
        }
        return $shippings;
    }

}
