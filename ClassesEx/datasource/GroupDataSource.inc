<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Group.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class GroupDataSource
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


    public function Insert(Group $group)
    {

        $SQL = "Insert Into groups(Name,LatinName,Image,PlaceAsMainCat) Values ('" . $group->getName() . "','" . $group->getLatinName() . "','" . $group->getImage() . "','" . $group->getPlaceAsMainCat() . "')";
        $this->da->exec($SQL);
    }

    public function Update(Group $group)
    {
        $SQL = "Update groups Set `Name` = '" . $group->getName() . "', LatinName = '" . $group->getLatinName() . "', Image = '" . $group->getImage() . "', PlaceAsMainCat = '" . $group->getPlaceAsMainCat() . "' Where GroupId=" . $group->getGroupId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From groups Where GroupId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from groups ";
        $results = $this->da->execSelect($SQL);
        $groups = array();
        while ($row = mysqli_fetch_array($results)) {
            $group = new Group();
            $group->setGroupId($row['GroupId']);
            $group->setName($row['Name']);
            $group->setLatinName($row['LatinName']);
            $group->setImage($row['Image']);
            $group->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $groups[] = $group;
        }
        return $groups;
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(GroupId) from groups";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(GroupId)'];
        }
    }

    public function FindOneGroupBasedOnId($id)
    {
        $SQL = "Select * from groups where GroupId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $group = new Group();
            $group->setGroupId($row['GroupId']);
            $group->setName($row['Name']);
            $group->setLatinName($row['LatinName']);
            $group->setImage($row['Image']);
            $group->setPlaceAsMainCat($row['PlaceAsMainCat']);
            return $group;
        }
    }

    public function getGroupId(Group $group)
    {
        $SQL = "Select GroupId from groups where Name Like '%" . $group->getName() . "%' || LatinName Like '%" . $group->getName() . "%' Limit 1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['GroupId'];
        }
    }

    public function getPlaceAsMainCat()
    {
        $SQL = "Select * from groups where PlaceAsMainCat = 1";
        $results = $this->da->execSelect($SQL);
        $groups = array();
        while ($row = mysqli_fetch_array($results)) {
            $group = new Group();
            $group->setGroupId($row['GroupId']);
            $group->setName($row['Name']);
            $group->setLatinName($row['LatinName']);
            $group->setImage($row['Image']);
            $group->setPlaceAsMainCat($row['PlaceAsMainCat']);
            $groups[] = $group;
        }
        return $groups;
    }

}
