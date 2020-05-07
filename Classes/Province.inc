<?php

require_once 'DataAccess.inc';

class Province {

    public $ProvinceId;
    public $Name;

    public function __construct() {
        $this->ProvinceId = 0;
        $this->Name = "";        
    }
    
    public function Fill() {
        $SQL = "Select * From provinces";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);                
        while ($row = mysqli_fetch_array($results)) {            
            $name = $row['name'];            
        }
        return $name;
    }

}
