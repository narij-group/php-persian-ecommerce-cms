<?php

require_once 'DataAccess.inc';

class Search {

    public $Product;

    public function __construct() {
        $this->Product = 0;
    }

    public function Fill($Query) {
        $SQL = "Select * From ( $Query ) a  ORDER BY Quantity =0, Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $paps = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->Product = $row['Product'];
            $paps[$i] = $pap;
            $i++;
        }
        return $paps;
    }
    
    public function CustomFill($Query , $order , $order2) {
        $SQL = "Select * From ( $Query ) a  ORDER BY Quantity =0, $order $order2";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $paps = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->Product = $row['Product'];
            $paps[$i] = $pap;
            $i++;
        }
        return $paps;
    }

}
