<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Guarantee.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class GuaranteeDataSource
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

    public function Insert(Guarantee $guarantee)
    {
        $SQL = "Insert Into guarantees(`Product`,Guarantee,Date) Values (" . $guarantee->Product . " , " . $guarantee->Guarantee . ",'" . $guarantee->Date . "')";
        $this->da->exec($SQL);
    }

    public function Update(Guarantee $guarantee)
    {
        $SQL = "Update guarantees Set Guarantee=" . $guarantee->Guarantee . " Where GuaranteeId=" . $guarantee->GuaranteeId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From `guarantees` Where GuaranteeId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteGuaranteesBasedOnGuarranteeList($id)
    {
        $SQL = "Delete From  `guarantees` Where Guarantee= " . $id;
        $this->da->exec($SQL);
    }


    public function DeleteGuaranteesRelatedToProduct($productId)
    {
        $SQL = "DELETE guarantees.* From guarantees Inner Join guaranteelists on GuaranteeListId = Guarantee Where guarantees.Product=" . $productId;
        $this->da->exec($SQL);
    }


    public function FindOneGuaranteeBasedOnId($id)
    {
        $SQL = "Select * From `guarantees` Inner Join guaranteelists on GuaranteeListId = Guarantee Where GuaranteeId=" . $id;
        $results = $this->da->execSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select * From `guarantees` Inner Join guaranteelists on GuaranteeListId = Guarantee ";
        $results = $this->da->execSelect($SQL);
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

    public function GetGuaranteesForOneProduct($productId)
    {
        $SQL = "Select * From guarantees Inner Join guaranteelists on GuaranteeListId = Guarantee Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
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

    public function GetThisGuaranteeProducts($guarantee_id)
    {
        $SQL = "Select * From guarantees Inner Join guaranteelists on GuaranteeListId = Guarantee Where Guarantee = " . $guarantee_id . " ORDER BY Product DESC";
        $results = $this->da->execSelect($SQL);
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
