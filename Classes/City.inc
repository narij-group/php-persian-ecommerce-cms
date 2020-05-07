<?php

require_once 'DataAccess.inc';

class City {

    public $CityId;
    public $Province;
    public $Name;

    public function __construct() {
        $this->CityId = 0;
        $this->Name = "";        
        $this->Province = 0;        
    }
    
    public function Fill() {
        $SQL = "Select * From cities";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $cities = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $city = new City();
            $city->CityId = $row['id'];
            $city->Name = $row['name'];
            $city->Province = $row['province_id'];
            $cities[$i] = $city;
            $i++;
        }
        return $cities;
    }
    
    public function GetOneProvinceCities($id) {
        $SQL = "Select * From cities where province_id = $id Order BY name ASC";                
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $cities = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $city = new City();
            $city->CityId = $row['id'];
            $city->Name = $row['name'];
            $city->Province = $row['province_id'];
            $cities[$i] = $city;
            $i++;
        }
        return $cities;
    }
    
    public function GetName($id) {
        $SQL = "Select name From cities where id = $id";                
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);                
        while ($row = mysqli_fetch_array($results)) {
            $name = $row['name'];
        }
        return $name;
    }
    
    
    
    

}
