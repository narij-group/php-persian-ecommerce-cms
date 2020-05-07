<?php

require_once 'DataAccess.inc';
require_once 'GuaranteeList.inc';

class Guarantee {

    public $GuaranteeId;
    public $Product;
    public $Guarantee;
    public $Date;

    public function __construct() {
        $this->GuaranteeId = 0;
        $this->Product = 0;
        $this->Guarantee = new GuaranteeList();
        $this->Date = date("Y/m/d");
    }

    public function Insert() {
        $SQL = "Insert Into guarantees(`Product`,Guarantee,Date) Values (" . $this->Product . " , " . $this->Guarantee . ",'" . $this->Date . "')";               
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update guarantees Set Guarantee=" . $this->Guarantee . " Where GuaranteeId=" . $this->GuaranteeId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From `guarantees` Where GuaranteeId= " . $this->GuaranteeId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneGuarantee() {
        $SQL = "Select * From `guarantees` Inner Join guaranteelists on GuaranteeListId = Guarantee Where GuaranteeId=" . $this->GuaranteeId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $guarantee = new Guarantee();
            $guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Product = $row['Product'];
            $guarantee->Guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Guarantee->Name = $row['Name'];
            $guarantee->Guarantee->Duration = $row['Duration'];
            $guarantee->Guarantee->Price = $row['Price'];
            $guarantee->Date = $row['Date'];
            return $guarantee;
        }
    }

    public function Fill() {
        $SQL = "Select * From `guarantees` Inner Join guaranteelists on GuaranteeListId = Guarantee ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $guarantees = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $guarantee = new Guarantee();
            $guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Product = $row['Product'];
            $guarantee->Guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Guarantee->Name = $row['Name'];
            $guarantee->Guarantee->Duration = $row['Duration'];
            $guarantee->Guarantee->Price = $row['Price'];
            $guarantee->Date = $row['Date'];
            $guarantees[$i] = $guarantee;
            $i++;
        }
        return $guarantees;
    }

    public function GetGuaranteesForOneProduct($productId) {
        $SQL = "Select * From guarantees Inner Join guaranteelists on GuaranteeListId = Guarantee Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $guarantees = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $guarantee = new Guarantee();
            $guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Product = $row['Product'];
            $guarantee->Guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Guarantee->Name = $row['Name'];
            $guarantee->Guarantee->Duration = $row['Duration'];
            $guarantee->Guarantee->Price = $row['Price'];
            $guarantee->Date = $row['Date'];
            $guarantees[$i] = $guarantee;
            $i++;
        }
        return $guarantees;
    }
    public function GetThisGuaranteeProducts($guarantee_id) {
        $SQL = "Select * From guarantees Inner Join guaranteelists on GuaranteeListId = Guarantee Where Guarantee = ".$guarantee_id." ORDER BY Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $guarantees = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $guarantee = new Guarantee();
            $guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Product = $row['Product'];
            $guarantee->Guarantee->GuaranteeId = $row['GuaranteeId'];
            $guarantee->Guarantee->Name = $row['Name'];
            $guarantee->Guarantee->Duration = $row['Duration'];
            $guarantee->Guarantee->Price = $row['Price'];
            $guarantee->Date = $row['Date'];
            $guarantees[$i] = $guarantee;
            $i++;
        }
        return $guarantees;
    }

}
