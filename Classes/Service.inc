<?php

require_once 'DataAccess.inc';

class Service {

    public $ServiceId;
    public $Name;
    public $Activated;
    public $Price;

    public function __construct() {
        $this->ServiceId = 0;
        $this->Name = "";
        $this->Activated = 1;
        $this->Price = NULL;
    }

    public function Insert() {
        $SQL = "Insert Into services(Name,Activated,Price) Values ('" . $this->Name . "' , " . $this->Activated . ", " . $this->Price . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update services Set `Activated`=" . $this->Activated . ",`Price`=" . $this->Price . " , Name ='" . $this->Name . "' Where ServiceId=" . $this->ServiceId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From services Where ServiceId= " . $this->ServiceId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneService() {
        $SQL = "Select * From services Where ServiceId=" . $this->ServiceId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
