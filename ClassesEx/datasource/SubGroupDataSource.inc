<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/SubGroup.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SubGroupDataSource
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

    public function Insert(SubGroup $subGroup)
    {
        $SQL = "Insert Into subgroups(`Group`,Name,LatinName,Image,PlaceAsMainCat) Values (" . $subGroup->getGroup() . ",'" . $subGroup->getName() . "','" . $subGroup->getLatinName() . "','" . $subGroup->getImage()  . "','" . $subGroup->getPlaceAsMainCat() . "')";
        $this->da->exec($SQL);
    }

    public function Update(SubGroup $subGroup)
    {
        $SQL = "Update subgroups Set `Name` = '" . $subGroup->getName() . "', LatinName = '" . $subGroup->getLatinName() .  "', Image = '" . $subGroup->getImage() . "', PlaceAsMainCat = '" . $subGroup->getPlaceAsMainCat()  . "' , `Group`=" . $subGroup->getGroup() . " Where SubGroupId=" . $subGroup->getSubGroupId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From subgroups Where SubGroupId = " . $id;
        $this->da->exec($SQL);
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(SubGroupId) from subgroups";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(SubGroupId)'];
        }
    }

    public function Fill()
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.Image , subgroups.PlaceAsMainCat , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group ";
        $results = $this->da->execSelect($SQL);
        $subgroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->setSubGroupId($row['SubGroupId']);
            $subgroup->getGroup()->setGroupId($row['GroupId']);
            $subgroup->getGroup()->setLatinName($row['GLatinName']);
            $subgroup->getGroup()->setName($row['GName']);
            $subgroup->setName($row['Name']);
            $subgroup->setLatinName($row['LatinName']);
            $subgroup->setImage($row['Image']);
            $subgroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $subgroups[] = $subgroup;
        }
        return $subgroups;
    }

    public function GetRandomId()
    {
        $SQL = "Select SubGroupId from subgroups";
        $results = $this->da->execSelect($SQL);
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
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.Image , subgroups.PlaceAsMainCat , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group Where subgroups.Group = $group";
        $results = $this->da->execSelect($SQL);
        $subgroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->setSubGroupId($row['SubGroupId']);
            $subgroup->getGroup()->setGroupId($row['GroupId']);
            $subgroup->getGroup()->setLatinName($row['GLatinName']);
            $subgroup->getGroup()->setName($row['GName']);
            $subgroup->setName($row['Name']);
            $subgroup->setLatinName($row['LatinName']);
            $subgroup->setImage($row['Image']);
            $subgroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $subgroups[] = $subgroup;
        }
        return $subgroups;
    }

    public function FindOneSubGroupBasedOnId($id)
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.Image , subgroups.PlaceAsMainCat , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group where SubGroupId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->setSubGroupId($row['SubGroupId']);
            $subgroup->getGroup()->setGroupId($row['GroupId']);
            $subgroup->getGroup()->setLatinName($row['GLatinName']);
            $subgroup->getGroup()->setName($row['GName']);
            $subgroup->setName($row['Name']);
            $subgroup->setLatinName($row['LatinName']);
            $subgroup->setImage($row['Image']);
            $subgroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            return $subgroup;
        }
    }

    public function getSubGroupId(SubGroup $subGroup)
    {
        $SQL = "Select SubGroupId from subgroups where Name Like '%" . $subGroup->getName() . "%' || LatinName Like '%" . $subGroup->getName() . "%' Limit 1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['SubGroupId'];
        }
    }

    public function getPlaceAsMainCat()
    {
        $SQL = "Select subgroups.Name ,subgroups.LatinName , subgroups.Image , subgroups.PlaceAsMainCat , subgroups.SubGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName from subgroups Inner Join groups on groups.GroupId = subgroups.Group where subgroups.PlaceAsMainCat = 1";
        $results = $this->da->execSelect($SQL);
        $subgroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $subgroup = new SubGroup();
            $subgroup->setSubGroupId($row['SubGroupId']);
            $subgroup->getGroup()->setGroupId($row['GroupId']);
            $subgroup->getGroup()->setLatinName($row['GLatinName']);
            $subgroup->getGroup()->setName($row['GName']);
            $subgroup->setName($row['Name']);
            $subgroup->setLatinName($row['LatinName']);
            $subgroup->setImage($row['Image']);
            $subgroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $subgroups[] = $subgroup;
        }
        return $subgroups;
    }

}
