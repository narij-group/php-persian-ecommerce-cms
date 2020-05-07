<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/City.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class CityDataSource
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

    public function Fill()
    {
        $sql = "Select * From cities";
        $results = $this->da->execSelect($sql);
        $cities = array();
        while ($row = mysqli_fetch_array($results)) {
            $city = new City();
            $city->setCityId($row['id']);
            $city->setName($row['name']);
            $city->setProvince($row['province_id']);
            $cities[] = $city;
        }
        return $cities;
    }

    public function GetOneProvinceCities($id)
    {
        $sql = "Select * From cities where province_id = $id Order BY name ASC";
        $results = $this->da->execSelect($sql);
        $cities = array();
        while ($row = mysqli_fetch_array($results)) {
            $city = new City();
            $city->setCityId($row['id']);
            $city->setName($row['name']);
            $city->setProvince($row['province_id']);
            $cities[] = $city;
        }
        return $cities;
    }

    public function GetName($id)
    {
        $sql = "Select name From cities where id = $id";
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            $name = $row['name'];
        }
        return $name;
    }


}
