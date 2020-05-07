<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/GuaranteeList.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class GuaranteeListDataSource
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

    public function Insert(GuaranteeList $guaranteeList)
    {

        $SQL = "Insert Into guaranteelists(Name,Price,Duration) Values ('" . $guaranteeList->Name . "' , " . $guaranteeList->Price . ",'" . $guaranteeList->Duration . "')";
        $this->da->exec($SQL);
    }

    public function Update(GuaranteeList $guaranteeList)
    {
        $SQL = "Update guaranteelists Set Name='" . $guaranteeList->Name . "' , Price=" . $guaranteeList->Price . ",Duration='" . $guaranteeList->Duration . "' Where GuaranteeListId=" . $guaranteeList->GuaranteeListId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From `guaranteelists` Where GuaranteeListId= " . $id;
        $this->da->exec($SQL);
    }

    public function K_Delete($id)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'GuaranteeDataSource.inc';
        $SQL = "Delete From `guaranteelists` Where GuaranteeListId= " . $id;
        $this->da->exec($SQL);
        $pg = new GuaranteeDataSource();
        $pg->open();
        $pg->DeleteGuaranteesBasedOnGuarranteeList($id);
        $pg->close();
    }

    public function FindOneGuaranteeListBasedOnId($id)
    {
        $SQL = "Select * From `guaranteelists` Where GuaranteeListId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $guaranteelist = new GuaranteeList();
            $guaranteelist->GuaranteeListId = $row['GuaranteeListId'];
            $guaranteelist->Name = $row['Name'];
            $guaranteelist->Duration = $row['Duration'];
            $guaranteelist->Price = $row['Price'];
            return $guaranteelist;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From `guaranteelists`";
        $results = $this->da->execSelect($SQL);
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
