<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Logo.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class LogoDataSource
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


    public function Insert(Logo $logo)
    {
        $SQL = "Insert Into logos(`Image`,Name,LatinName,Activated) Values ('" . $logo->getImage() . "','" . $logo->getName() . "','" . $logo->getLatinName() . "'," . $logo->getActivated() . ")";
        $this->da->exec($SQL);
    }

    public function Update(Logo $logo)
    {
        $SQL = "Update logos Set `Name` = '" . $logo->getName() . "',Activated = " . $logo->getActivated() . ", LatinName = '" . $logo->getLatinName() . "' , `Image`='" . $logo->getImage() . "' Where LogoId=" . $logo->getLogoId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From logos Where LogoId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from logos ";
        $results = $this->da->execSelect($SQL);
        $logos = array();
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->setLogoId($row['LogoId']);
            $logo->setActivated( $row['Activated']);
            $logo->setImage($row['Image']);
            $logo->setName( $row['Name']);
            $logo->setLatinName($row['LatinName']);
            $logos[] = $logo;
        }
        return $logos;
    }

    public function FillActives()
    {
        $SQL = "Select * from logos where Activated = 1";
        $results = $this->da->execSelect($SQL);
        $logos = array();
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->setLogoId($row['LogoId']);
            $logo->setActivated( $row['Activated']);
            $logo->setImage($row['Image']);
            $logo->setName( $row['Name']);
            $logo->setLatinName($row['LatinName']);
            $logos[] = $logo;
        }
        return $logos;
    }

    public function FindOneLogoBasedOnId($id)
    {
        $SQL = "Select * from logos where LogoId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->setLogoId($row['LogoId']);
            $logo->setActivated( $row['Activated']);
            $logo->setImage($row['Image']);
            $logo->setName( $row['Name']);
            $logo->setLatinName($row['LatinName']);
            return $logo;
        }
    }

    public function getLogoId(Logo $logo)
    {
        $SQL = "Select LogoId from logos where '%" . $logo->getName() . "%' = (Name + ' | ' + LatinName) Limit 1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['LogoId'];
        }
    }

}
