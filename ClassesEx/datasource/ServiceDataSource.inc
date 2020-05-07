<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Service.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ServiceDataSource {

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

    public function Insert(Service $service) {
        $SQL = "Insert Into services(Name,Activated,Price) Values ('" . $service->Name . "' , " . $service->Activated . ", " . $service->Price . ")";
        $this->da->exec($SQL);
    }

    public function Update(Service $service) {
        $SQL = "Update services Set `Activated`=" . $service->Activated . ",`Price`=" . $service->Price . " , Name ='" . $service->Name . "' Where ServiceId=" . $service->ServiceId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From services Where ServiceId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneServiceBasedOnId($id) {
        $SQL = "Select * From services Where ServiceId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $service = new Service();
            $service->ServiceId = $row['ServiceId'];
            $service->Name = $row['Name'];
            $service->Activated = $row['Activated'];
            $service->Price = $row['Price'];
            return $service;
        }
    }

    public function Fill() {
        $SQL = "Select * FROM services ";
        $results = $this->da->execSelect($SQL);
        $services = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $service = new Service();
            $service->ServiceId = $row['ServiceId'];
            $service->Name = $row['Name'];
            $service->Activated = $row['Activated'];
            $service->Price = $row['Price'];
            $services[$i] = $service;
            $i++;
        }
        return $services;
    }
    public function CFill() {
        $SQL = "Select * FROM services WHERE Activated = 1";
        $results = $this->da->execSelect($SQL);
        $services = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $service = new Service();
            $service->ServiceId = $row['ServiceId'];
            $service->Name = $row['Name'];
            $service->Activated = $row['Activated'];
            $service->Price = $row['Price'];
            $services[$i] = $service;
            $i++;
        }
        return $services;
    }

}
