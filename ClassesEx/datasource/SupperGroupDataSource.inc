<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/SupperGroup.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SupperGroupDataSource
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


    public function Insert(SupperGroup $supperGroup)
    {
        $SQL = "Insert Into suppergroups(`Group`,`SubGroup`,Name,LatinName,Image,PlaceAsMainCat) Values (" . $supperGroup->getGroup() . "," . $supperGroup->getSubGroup() . ",'" . $supperGroup->getName() . "','" . $supperGroup->getLatinName() . "','" . $supperGroup->getImage() . "','" . $supperGroup->getPlaceAsMainCat() . "')";
        $this->da->exec($SQL);
    }

    public function Update(SupperGroup $supperGroup)
    {
        $SQL = "Update suppergroups Set `Name` = '" . $supperGroup->getName() . "', LatinName = '" . $supperGroup->getLatinName() . "', Image = '" . $supperGroup->getImage() . "', PlaceAsMainCat = '" . $supperGroup->getPlaceAsMainCat() . "' , `Group`=" . $supperGroup->getGroup() . ", `SubGroup`=" . $supperGroup->getSubGroup() . " Where SupperGroupId=" . $supperGroup->getSupperGroupId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From suppergroups Where SupperGroupId = " . $id;
        $this->da->exec($SQL);
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(SupperGroupId) from suppergroups";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(SupperGroupId)'];
        }
    }

    public function Fill()
    {
        $SQL = "Select suppergroups.Name , suppergroups.LatinName , suppergroups.Image, suppergroups.PlaceAsMainCat , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup ";
        $results = $this->da->execSelect($SQL);
        $suppergroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->getGroup()->setGroupId($row['GroupId']);
            $suppergroup->getGroup()->setLatinName($row['GLatinName']);
            $suppergroup->getGroup()->setName($row['GName']);
            $suppergroup->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $suppergroup->getSubGroup()->setGroup($row['SGGroup']);
            $suppergroup->getSubGroup()->setLatinName($row['SGLatinName']);
            $suppergroup->getSubGroup()->setName($row['SGName']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $suppergroups[] = $suppergroup;
        }
        return $suppergroups;
    }

    public function SearchSupperGroups($s)
    {
        $SQL = "Select * From suppergroups WHERE Name LIKE '%$s%' ||  LatinName LIKE '%$s%'";
        $results = $this->da->execSelect($SQL);
        $suppergroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $suppergroups[] = $suppergroup;
        }
        return $suppergroups;
    }

    public function FillByGroupAndSubgroup($group, $subgroup)
    {
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.Image , suppergroups.PlaceAsMainCat , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup Where suppergroups.Group = $group And suppergroups.Subgroup = $subgroup ";
        $results = $this->da->execSelect($SQL);
        $suppergroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->getGroup()->setGroupId($row['GroupId']);
            $suppergroup->getGroup()->setLatinName($row['GLatinName']);
            $suppergroup->getGroup()->setName($row['GName']);
            $suppergroup->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $suppergroup->getSubGroup()->setGroup($row['SGGroup']);
            $suppergroup->getSubGroup()->setLatinName($row['SGLatinName']);
            $suppergroup->getSubGroup()->setName($row['SGName']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $suppergroups[] = $suppergroup;
        }
        return $suppergroups;
    }

    public function FillBySubgroup($subgroup)
    {
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.Image , suppergroups.PlaceAsMainCat , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup Where suppergroups.Subgroup = $subgroup ";
        $results = $this->da->execSelect($SQL);
        $suppergroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->getGroup()->setGroupId($row['GroupId']);
            $suppergroup->getGroup()->setLatinName($row['GLatinName']);
            $suppergroup->getGroup()->setName($row['GName']);
            $suppergroup->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $suppergroup->getSubGroup()->setGroup($row['SGGroup']);
            $suppergroup->getSubGroup()->setLatinName($row['SGLatinName']);
            $suppergroup->getSubGroup()->setName($row['SGName']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $suppergroups[] = $suppergroup;
        }
        return $suppergroups;
    }

    public function FindOneSupperGroupBasedOnId($id)
    {
        $SQL = "Select suppergroups.Name ,suppergroups.LatinName , suppergroups.Image, suppergroups.PlaceAsMainCat , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup where SupperGroupId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->getGroup()->setGroupId($row['GroupId']);
            $suppergroup->getGroup()->setLatinName($row['GLatinName']);
            $suppergroup->getGroup()->setName($row['GName']);
            $suppergroup->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $suppergroup->getSubGroup()->setGroup($row['SGGroup']);
            $suppergroup->getSubGroup()->setLatinName($row['SGLatinName']);
            $suppergroup->getSubGroup()->setName($row['SGName']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            return $suppergroup;
        }
    }

    public function getSupperGroupId(SupperGroup $supperGroup)
    {
        $SQL = "Select SupperGroupId from suppergroups where Name Like '%" . $supperGroup->getName() . "%' || LatinName Like '%" . $supperGroup->getName() . "%' Limit 1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['SupperGroupId'];
        }
    }

    public function getPlaceAsMainCat()
    {
        $SQL = "Select suppergroups.Name , suppergroups.LatinName , suppergroups.Image, suppergroups.PlaceAsMainCat , suppergroups.SupperGroupId , groups.GroupId , groups.Name as GName , groups.LatinName as GLatinName , subgroups.SubGroupId , subgroups.Name as SGName , subgroups.LatinName as SGLatinName ,subgroups.Group as SGGroup from suppergroups Inner Join groups on groups.GroupId = suppergroups.Group Inner Join subgroups on subgroups.SubgroupId = suppergroups.SubGroup  where suppergroups.PlaceAsMainCat = 1";
        $results = $this->da->execSelect($SQL);
        $suppergroups = array();
        while ($row = mysqli_fetch_array($results)) {
            $suppergroup = new SupperGroup();
            $suppergroup->setSupperGroupId($row['SupperGroupId']);
            $suppergroup->getGroup()->setGroupId($row['GroupId']);
            $suppergroup->getGroup()->setLatinName($row['GLatinName']);
            $suppergroup->getGroup()->setName($row['GName']);
            $suppergroup->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $suppergroup->getSubGroup()->setGroup($row['SGGroup']);
            $suppergroup->getSubGroup()->setLatinName($row['SGLatinName']);
            $suppergroup->getSubGroup()->setName($row['SGName']);
            $suppergroup->setName($row['Name']);
            $suppergroup->setLatinName($row['LatinName']);
            $suppergroup->setImage($row['Image']);
            $suppergroup->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $suppergroups[] = $suppergroup;
        }
        return $suppergroups;
    }

}
