<?php

require_once 'DataAccess.inc';

class Shipping {

    public $ShippingId;
    public $City;    
    public $Price;

    public function __construct() {
        $this->ShippingId = 0;
        $this->City = "";
        $this->Price = 0;
    }

    public function Insert() {
        $SQL = "Insert Into shippings(City,Price) Values ('".$this->City."' , " . $this->Price . ")";                
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update shippings Set `Price`=" . $this->Price . " Where ShippingId=" . $this->ShippingId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From shippings Where ShippingId= " . $this->ShippingId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneShipping() {
        $SQL = "Select * From shippings Where ShippingId=" . $this->ShippingId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $shipping = new Shipping();
            $shipping->ShippingId = $row['ShippingId'];
            $shipping->City = $row['City'];
            $shipping->Price = $row['Price'];
            return $shipping;
        }
    }
    
    public function FindOneShippingByProvince() {
        $SQL = "Select City,ShippingId,IFNULL(Price,0) From shippings Where City=" . $this->City;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
