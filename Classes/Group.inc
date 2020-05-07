<?php

require_once 'DataAccess.inc';

class Group {

    public $GroupId;
    public $Name;
    public $LatinName;

    public function __construct() {
        $this->GroupId = 0;
        $this->Name = "";
        $this->LatinName = "";
    }

    public function Insert() {

        $SQL = "Insert Into groups(Name,LatinName) Values ('" . $this->Name . "','" . $this->LatinName . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update groups Set `Name` = '".$this->Name."', LatinName = '".$this->LatinName."' Where GroupId=" . $this->GroupId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From groups Where GroupId = " . $this->GroupId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from groups ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $groups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $group = new Group();
            $group->GroupId = $row['GroupId'];
            $group->Name = $row['Name'];
            $group->LatinName = $row['LatinName'];
            $groups[$i] = $group;
            $i++;
        }
        return $groups;
    }
    
    public function FirstId() {
        $Id = "SELECT MIN(GroupId) from groups";
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {                            
            return $row['MIN(GroupId)'];
        }
    }

    public function FindOneGroup() {
        $SQL = "Select * from groups where GroupId = ". $this->GroupId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $group = new Group();
            $group->GroupId = $row['GroupId'];
            $group->Name = $row['Name'];            
            $group->LatinName = $row['LatinName'];
            return $group;
        }        
    }

    public function getGroupId()
    {
        $SQL = "Select GroupId from groups where Name Like '%" . $this->Name . "%' || LatinName Like '%" . $this->Name . "%' Limit 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['GroupId'];
        }
    }

}
