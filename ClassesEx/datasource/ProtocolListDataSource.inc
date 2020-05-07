<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ProtocolList.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProtocolListDataSource {

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

    public function Insert(ProtocolList $protocolList) {

        $SQL = "Insert Into protocollists(`Image`,Name) Values ('" . $protocolList->Image . "','" . $protocolList->Name . "')";
        $this->da->exec($SQL);
    }

    public function Update(ProtocolList $protocolList) {
        $SQL = "Update protocollists Set `Name` = '".$protocolList->Name."' , `Image`='" . $protocolList->Image . "' Where ProtocolListId=" . $protocolList->ProtocolListId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From protocollists Where ProtocolListId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill() {
        $SQL = "Select * from protocollists ";
        $results = $this->da->execSelect($SQL);
        $protocollists = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $protocollist = new ProtocolList();
            $protocollist->ProtocolListId = $row['ProtocolListId'];
            $protocollist->Image = $row['Image'];
            $protocollist->Name = $row['Name'];
            $protocollists[$i] = $protocollist;
            $i++;
        }
        return $protocollists;
    }        

    public function FindOneProtocolListBasedOnId($id) {
        $SQL = "Select * from protocollists where ProtocolListId = ". $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $protocollist = new ProtocolList();
            $protocollist->ProtocolListId = $row['ProtocolListId'];
            $protocollist->Image = $row['Image'];            
            $protocollist->Name = $row['Name'];            
            return $protocollist;
        }        
    }

}
