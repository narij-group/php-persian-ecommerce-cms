<?php

require_once 'DataAccess.inc';
require_once 'Group.inc';

class SubGroup
{

    public $SubGroupId;
    public $Group;
    public $Name;
    public $LatinName;

    public function __construct()
    {
        $this->SubGroupId = 0;
        $this->Group = new Group();
        $this->Name = "";
        $this->LatinName = "";
    }

    public function Insert()
    {
        $SQL = "Insert Into subgroups(`Group`,Name,LatinName) Values (" . $this->Group . ",'" . $this->Name . "','" . $this->LatinName . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update subgroups Set `Name` = '" . $this->Name . "', LatinName = '" . $this->LatinName . "' , `Group`=" . $this->Group . " Where SubGroupId=" . $this->SubGroupId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From subgroups Where SubGroupId = " . $this->SubGroupId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(SubGroupId) from subgroups";
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(SubGroupId)'];
        }
    }

    public function Fill()
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $subgroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->SubGroupId = $row['SubGroupId'];
            $subgroup->Group->GroupId = $row['GroupId'];
            $subgroup->Group->LatinName = $row['GLatinName'];
            $subgroup->Group->Name = $row['GName'];
            $subgroup->Name = $row['Name'];
            $subgroup->LatinName = $row['LatinName'];
            $subgroups[$i] = $subgroup;
            $i++;
        }
        return $subgroups;
    }

    public function GetRandomId()
    {
        $SQL = "Select SubGroupId from subgroups";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $subgroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $subgroups[$i] = $row['SubGroupId'];
            $i++;
        }
        shuffle($subgroups);
        return $subgroups[0];
    }

    public function FillByGroup($group)
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group Where subgroups.Group = $group";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $subgroups = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->SubGroupId = $row['SubGroupId'];
            $subgroup->Group->GroupId = $row['GroupId'];
            $subgroup->Group->LatinName = $row['GLatinName'];
            $subgroup->Group->Name = $row['GName'];
            $subgroup->Name = $row['Name'];
            $subgroup->LatinName = $row['LatinName'];
            $subgroups[$i] = $subgroup;
            $i++;
        }
        return $subgroups;
    }

    public function FindOneSubGroup()
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group where SubGroupId = " . $this->SubGroupId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->SubGroupId = $row['SubGroupId'];
            $subgroup->Group->GroupId = $row['GroupId'];
            $subgroup->Group->LatinName = $row['GLatinName'];
            $subgroup->Group->Name = $row['GName'];
            $subgroup->Name = $row['Name'];
            $subgroup->LatinName = $row['LatinName'];
            return $subgroup;
        }
    }

    public function getSubGroupId()
    {
        $SQL = "Select SubGroupId from subgroups where Name Like '%" . $this->Name . "%' || LatinName Like '%" . $this->Name . "%' Limit 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['SubGroupId'];
        }
    }

}
