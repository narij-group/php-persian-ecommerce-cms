<?php

require_once 'DataAccess.inc';

class ProtocolList {

    public $ProtocolListId;
    public $Image;
    public $Name;

    public function __construct() {
        $this->ProtocolListId = 0;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
    }

    public function Insert() {

        $SQL = "Insert Into protocollists(`Image`,Name) Values ('" . $this->Image . "','" . $this->Name . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update protocollists Set `Name` = '".$this->Name."' , `Image`='" . $this->Image . "' Where ProtocolListId=" . $this->ProtocolListId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From protocollists Where ProtocolListId = " . $this->ProtocolListId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from protocollists ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function FindOneProtocolList() {
        $SQL = "Select * from protocollists where ProtocolListId = ". $this->ProtocolListId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $protocollist = new ProtocolList();
            $protocollist->ProtocolListId = $row['ProtocolListId'];
            $protocollist->Image = $row['Image'];            
            $protocollist->Name = $row['Name'];            
            return $protocollist;
        }        
    }

}
