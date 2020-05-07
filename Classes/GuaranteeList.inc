<?php

require_once 'DataAccess.inc';

class GuaranteeList {

    public $GuaranteeListId;    
    public $Name;
    public $Duration;
    public $Price;    

    public function __construct() {
        $this->GuaranteeListId = 0;        
        $this->Name = "";
        $this->Duration = "";
        $this->Price = NULL;        
    }

    public function Insert() {

        $SQL = "Insert Into guaranteelists(Name,Price,Duration) Values ('" . $this->Name . "' , " . $this->Price . ",'" . $this->Duration . "')";        
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update guaranteelists Set Name='" . $this->Name . "' , Price=" . $this->Price . ",Duration='" . $this->Duration . "' Where GuaranteeListId=" . $this->GuaranteeListId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From `guaranteelists` Where GuaranteeListId= " . $this->GuaranteeListId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneGuaranteeList() {
        $SQL = "Select * From `guaranteelists` Where GuaranteeListId=" . $this->GuaranteeListId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $guaranteelist = new GuaranteeList();
            $guaranteelist->GuaranteeListId = $row['GuaranteeListId'];
            $guaranteelist->Name = $row['Name'];
            $guaranteelist->Duration = $row['Duration'];
            $guaranteelist->Price = $row['Price'];
            return $guaranteelist;
        }
    }

    public function Fill() {
        $SQL = "Select * From `guaranteelists`";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $guaranteelists = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $guaranteelist = new GuaranteeList();
            $guaranteelist->GuaranteeListId = $row['GuaranteeListId'];
            $guaranteelist->Name = $row['Name'];
            $guaranteelist->Duration = $row['Duration'];
            $guaranteelist->Price = $row['Price'];
            $guaranteelists[$i] = $guaranteelist;
            $i++;
        }
        return $guaranteelists;
    }
}
