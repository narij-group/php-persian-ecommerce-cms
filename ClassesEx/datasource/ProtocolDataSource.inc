<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Protocol.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProtocolDataSource
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

    public function Insert(Protocol $protocol)
    {

        $SQL = "Insert Into protocols(ProtocolList,Product) Values (" . $protocol->ProtocolList . "," . $protocol->Product . ")";
        $this->da->exec($SQL);
    }

    public function Update(Protocol $protocol)
    {
        $SQL = "Update protocols Set `ProtocolList` = " . $protocol->ProtocolList . " Where ProtocolId=" . $protocol->ProtocolId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From protocols Where ProtocolId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from protocols INNER JOIN protocollists on ProtocolList = ProtocolListId ";
        $results = $this->da->execSelect($SQL);
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

    public function FindOneProtocolBasedOnId($id)
    {
        $SQL = "Select * from protocols INNER JOIN protocollists on ProtocolList = ProtocolListId where ProtocolId = " . $id;
        $results = $this->da->execSelect($SQL);
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

    public function GetProtocolsForOneProduct($productId)
    {
        $SQL = "Select * From protocols INNER JOIN protocollists on ProtocolList = ProtocolListId Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
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

    public function FindOneProtocolProducts(Protocol $protocol)
    {
        $SQL = "Select * From protocols where ProtocolList = " . $protocol->ProtocolList . " Order by Product DESC";
        $results = $this->da->execSelect($SQL);
        $protocols = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $protocols[$i] = $row['Product'];
            $i++;
        }
        return $protocols;
    }

}
