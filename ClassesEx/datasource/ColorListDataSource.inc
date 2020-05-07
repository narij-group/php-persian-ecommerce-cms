<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ColorList.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ColorListDataSource
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

    public function Insert(ColorList $colorList)
    {

        $SQL = "Insert Into colorlists(Name,Sample) Values ('" . $colorList->getName() . "' , '" . $colorList->getSample() . "')";
        $this->da->exec($SQL);
    }

    public function Update(ColorList $colorList)
    {
        $SQL = "Update colorlists Set Name='" . $colorList->getName() . "' , Sample='" . $colorList->getSample() . "' Where ColorListId=" . $colorList->getColorListId() . "";
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From `colorlists` Where ColorListId= " . $id;
        $this->da->exec($SQL);
    }

    public function K_Delete($id)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductColorDataSource.inc';
        $pcolor = new ProductColorDataSource();
        $pcolor->open();
        $pcolor->DeleteProductColorsRelatedToColorList($id);
        $pcolor->close();

        $SQL = "Delete From `colorlists` Where ColorListId= " . $id;
        $this->da->exec($SQL);
    }


    public function FindOneColorListBasedOnId($id)
    {
        $SQL = "Select * From `colorlists` Where ColorListId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->setColorListId($row['ColorListId']);
            $colorlist->setName($row['Name']);
            $colorlist->setSample($row['Sample']);
            return $colorlist;
        }
    }

    public function FindOneColorSample($name)
    {
        $SQL = "Select * From `colorlists` Where Name='" . $name . "' LIMIT 1";
        $results = $this->da->execSelect($SQL);

        while ($row = mysqli_fetch_array($results)) {
            return $row['Sample'];
        }
    }

    public function FindOneColorId($name)
    {
        $SQL = "Select * From `colorlists` Where Name='" . $name . "' LIMIT 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['ColorListId'];
        }
    }

    public function Fill()
    {
        $SQL = "Select * From `colorlists`";
        $results = $this->da->execSelect($SQL);
        $colorlists = array();
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->setColorListId($row['ColorListId']);
            $colorlist->setName($row['Name']);
            $colorlist->setSample($row['Sample']);
            $colorlists[] = $colorlist;
        }
        return $colorlists;
    }

    public function Fill2()
    {
        $SQL = "Select * From `colorlists` ORDER BY Name ASC";
        $results = $this->da->execSelect($SQL);
        $colorlists = array();
        while ($row = mysqli_fetch_array($results)) {
            $colorlist = new ColorList();
            $colorlist->setColorListId($row['ColorListId']);
            $colorlist->setName($row['Name']);
            $colorlist->setSample($row['Sample']);
            $colorlists[] = $colorlist;
        }
        return $colorlists;
    }
}
