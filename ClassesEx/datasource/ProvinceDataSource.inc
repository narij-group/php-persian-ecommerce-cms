<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Province.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProvinceDataSource {

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
    
    public function Fill() {
        $SQL = "Select * From provinces";
        $results = $this->da->execSelect($SQL);
        $provinces = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $province = new Province();
            $province->ProvinceId = $row['id'];
            $province->Name = $row['name'];
            $provinces[$i] = $province;
            $i++;
        }
        return $provinces;
    }
        
    public function GetName($id) {
        $SQL = "Select name From provinces where id = $id";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {            
            $name = $row['name'];            
        }
        return $name;
    }

}
