<?php

require_once 'DataAccess.inc';

class ColorList {

    public $ColorListId;    
    public $Name;
    public $Sample;

    public function __construct() {
        $this->ColorListId = 0;        
        $this->Name = "";
        $this->Sample = "";
    }

    public function Insert() {

        $SQL = "Insert Into colorlists(Name,Sample) Values ('" . $this->Name . "' , '" . $this->Sample . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update colorlists Set Name='" . $this->Name . "' , Sample='" . $this->Sample . "' Where ColorListId=" . $this->ColorListId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }  

    public function Delete() {
        $SQL = "Delete From `colorlists` Where ColorListId= " . $this->ColorListId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneColorList() {
        $SQL = "Select * From `colorlists` Where ColorListId=" . $this->ColorListId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->ColorListId = $row['ColorListId'];
            $colorlist->Name = $row['Name'];
            $colorlist->Sample = $row['Sample'];
            return $colorlist;
        }
    }
    public function FindOneColorSample($name) {
        $SQL = "Select * From `colorlists` Where Name='" . $name ."' LIMIT 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Sample'];
        }
    }
    public function FindOneColorId($name) {
        $SQL = "Select * From `colorlists` Where Name='" . $name ."' LIMIT 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['ColorListId'];
        }
    }

    public function Fill() {
        $SQL = "Select * From `colorlists`";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $colorlists = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->ColorListId = $row['ColorListId'];
            $colorlist->Name = $row['Name'];
            $colorlist->Sample = $row['Sample'];
            $colorlists[$i] = $colorlist;
            $i++;
        }
        return $colorlists;
    }
    public function Fill2() {
        $SQL = "Select * From `colorlists` ORDER BY Name ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $colorlists = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->ColorListId = $row['ColorListId'];
            $colorlist->Name = $row['Name'];
            $colorlist->Sample = $row['Sample'];
            $colorlists[$i] = $colorlist;
            $i++;
        }
        return $colorlists;
    }
}
