<?php

require_once 'DataAccess.inc';
require_once 'ProtocolList.inc';

class Protocol {

    public $ProtocolId;    
    public $ProtocolList;
    public $Product;

    public function __construct() {
        $this->ProtocolId = 0;
        $this->ProtocolList = new ProtocolList();
        $this->Product = 0;
    }

    public function Insert() {

        $SQL = "Insert Into protocols(ProtocolList,Product) Values (" . $this->ProtocolList . "," . $this->Product . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update protocols Set `ProtocolList` = ".$this->ProtocolList." Where ProtocolId=" . $this->ProtocolId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From protocols Where ProtocolId = " . $this->ProtocolId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from protocols INNER JOIN protocollists on ProtocolList = ProtocolListId ";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $protocols = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $protocol = new Protocol();
            $protocol->ProtocolId = $row['ProtocolId'];                        
            $protocol->Product = $row['Product'];
            $protocol->ProtocolList->ProtocolListId = $row['ProtocolListId'];
            $protocol->ProtocolList->Image = $row['Image'];
            $protocol->ProtocolList->Name = $row['Name'];
            $protocols[$i] = $protocol;
            $i++;
        }
        return $protocols;
    }

    public function FindOneProtocol() {
        $SQL = "Select * from protocols INNER JOIN protocollists on ProtocolList = ProtocolListId where ProtocolId = ". $this->ProtocolId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $protocol = new Protocol();
            $protocol->ProtocolId = $row['ProtocolId'];              
            $protocol->ProtocolList->ProtocolListId = $row['ProtocolListId'];
            $protocol->ProtocolList->Image = $row['Image'];
            $protocol->ProtocolList->Name = $row['Name'];
            $protocol->Product = $row['Product'];            
            return $protocol;
        }        
    }
    
    public function GetProtocolsForOneProduct($productId) {
        $SQL = "Select * From protocols INNER JOIN protocollists on ProtocolList = ProtocolListId Where Product=" . $productId;        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $protocols = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $protocol = new Protocol();
            $protocol->ProtocolId = $row['ProtocolId'];              
            $protocol->ProtocolList->ProtocolListId = $row['ProtocolListId'];
            $protocol->ProtocolList->Image = $row['Image'];
            $protocol->ProtocolList->Name = $row['Name'];
            $protocol->Product = $row['Product'];            
            $protocols[$i] = $protocol;
            $i++;
        }
        return $protocols;
    }
    
    public function FindOneProtocolProducts() {
        $SQL = "Select * From protocols where ProtocolList = " . $this->ProtocolList ." Order by Product DESC";        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $protocols = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $protocols[$i] = $row['Product'];
            $i++;
        }
        return $protocols;
    }

}
