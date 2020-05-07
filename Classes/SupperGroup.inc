<?php

require_once 'DataAccess.inc';
require_once 'Group.inc';
require_once 'SubGroup.inc';

class SupperGroup {

    public $SupperGroupId;
    public $Group;
    public $SubGroup;
    public $Name;
    public $LatinName;

    public function __construct() {
        $this->SupperGroupId = 0;
        $this->Group = new Group();
        $this->SubGroup = new SubGroup();
        $this->Name = "";
        $this->LatinName = "";
    }

    public function Insert() {
        $SQL = "Insert Into suppergroups(`Group`,`SubGroup`,Name,LatinName) Values (" . $this->Group . "," . $this->SubGroup . ",'" . $this->Name . "','" . $this->LatinName . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update suppergroups Set `Name` = '".$this->Name."', LatinName = '".$this->LatinName."' , `Group`=" . $this->Group . ", `SubGroup`=" . $this->SubGroup . " Where SupperGroupId=" . $this->SupperGroupId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From suppergroups Where SupperGroupId = " . $this->SupperGroupId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FirstId() {
        $Id = "SELECT MIN(SupperGroupId) from suppergroups";
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(SupperGroupId)'];
        }
    }

    public function Fill() {
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppergroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->SupperGroupId = $row['SupperGroupId'];
            $suppergroup->Group->GroupId = $row['GroupId'];
            $suppergroup->Group->LatinName = $row['GLatinName'];
            $suppergroup->Group->Name = $row['GName'];
            $suppergroup->SubGroup->SubGroupId = $row['SubGroupId'];
            $suppergroup->SubGroup->Group = $row['SGGroup'];
            $suppergroup->SubGroup->LatinName = $row['SGLatinName'];
            $suppergroup->SubGroup->Name = $row['SGName'];
            $suppergroup->Name = $row['Name'];
            $suppergroup->LatinName = $row['LatinName'];
            $suppergroups[$i] = $suppergroup;
            $i++;
        }
        return $suppergroups;
    }

    public function SearchSupperGroups($s) {
        $SQL = "Select * From suppergroups WHERE Name LIKE '%$s%' ||  LatinName LIKE '%$s%'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppergroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->SupperGroupId = $row['SupperGroupId'];
            $suppergroup->Name = $row['Name'];
            $suppergroup->LatinName = $row['LatinName'];
            $suppergroups[$i] = $suppergroup;
            $i++;
        }
        return $suppergroups;
    }
    
    public function FillByGroupAndSubgroup($group,$subgroup) {        
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup Where suppergroups.Group = $group And suppergroups.Subgroup = $subgroup " ;                        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppergroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->SupperGroupId = $row['SupperGroupId'];
            $suppergroup->Group->GroupId = $row['GroupId'];
            $suppergroup->Group->LatinName = $row['GLatinName'];
            $suppergroup->Group->Name = $row['GName'];
            $suppergroup->SubGroup->SubGroupId = $row['SubGroupId'];
            $suppergroup->SubGroup->Group = $row['SGGroup'];
            $suppergroup->SubGroup->LatinName = $row['SGLatinName'];
            $suppergroup->SubGroup->Name = $row['SGName'];
            $suppergroup->Name = $row['Name'];
            $suppergroup->LatinName = $row['LatinName'];
            $suppergroups[$i] = $suppergroup;
            $i++;
        }
        return $suppergroups;
    }
    
    public function FillBySubgroup($subgroup) {        
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup Where suppergroups.Subgroup = $subgroup " ;                        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppergroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->SupperGroupId = $row['SupperGroupId'];
            $suppergroup->Group->GroupId = $row['GroupId'];
            $suppergroup->Group->LatinName = $row['GLatinName'];
            $suppergroup->Group->Name = $row['GName'];
            $suppergroup->SubGroup->SubGroupId = $row['SubGroupId'];
            $suppergroup->SubGroup->Group = $row['SGGroup'];
            $suppergroup->SubGroup->LatinName = $row['SGLatinName'];
            $suppergroup->SubGroup->Name = $row['SGName'];
            $suppergroup->Name = $row['Name'];
            $suppergroup->LatinName = $row['LatinName'];
            $suppergroups[$i] = $suppergroup;
            $i++;
        }
        return $suppergroups;
    }

    public function FindOneSupperGroup() {
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup where SupperGroupId = ". $this->SupperGroupId;        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->SupperGroupId = $row['SupperGroupId'];
            $suppergroup->Group->GroupId = $row['GroupId'];
            $suppergroup->Group->LatinName = $row['GLatinName'];
            $suppergroup->Group->Name = $row['GName'];
            $suppergroup->SubGroup->SubGroupId = $row['SubGroupId'];
            $suppergroup->SubGroup->Group = $row['SGGroup'];
            $suppergroup->SubGroup->LatinName = $row['SGLatinName'];
            $suppergroup->SubGroup->Name = $row['SGName'];
            $suppergroup->Name = $row['Name'];            
            $suppergroup->LatinName = $row['LatinName'];
            return $suppergroup;
        }        
    }

    public function getSupperGroupId()
    {
        $SQL = "Select SupperGroupId from suppergroups where Name Like '%" . $this->Name . "%' || LatinName Like '%" . $this->Name . "%' Limit 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['SupperGroupId'];
        }
    }

}
