<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Search.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SearchDataSource {

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

    public function Fill($Query) {
        $SQL = "Select * From ( $Query ) a  ORDER BY Quantity =0, Product DESC";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
