<?php

require_once 'DataAccess.inc';

class Logo
{

    public $LogoId;
    public $Image;
    public $Name;
    public $LatinName;
    public $Activated;

    public function __construct()
    {
        $this->LogoId = 0;
        $this->Activated = 1;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
        $this->LatinName = "";
    }

    public function Insert()
    {

        $SQL = "Insert Into logos(`Image`,Name,LatinName,Activated) Values ('" . $this->Image . "','" . $this->Name . "','" . $this->LatinName . "'," . $this->Activated . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update logos Set `Name` = '" . $this->Name . "',Activated = " . $this->Activated . ", LatinName = '" . $this->LatinName . "' , `Image`='" . $this->Image . "' Where LogoId=" . $this->LogoId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From logos Where LogoId = " . $this->LogoId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from logos ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $logos = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->LogoId = $row['LogoId'];
            $logo->Activated = $row['Activated'];
            $logo->Image = $row['Image'];
            $logo->Name = $row['Name'];
            $logo->LatinName = $row['LatinName'];
            $logos[$i] = $logo;
            $i++;
        }
        return $logos;
    }

    public function FillActives()
    {
        $SQL = "Select * from logos where Activated = 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $logos = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->LogoId = $row['LogoId'];
            $logo->Activated = $row['Activated'];
            $logo->Image = $row['Image'];
            $logo->Name = $row['Name'];
            $logo->LatinName = $row['LatinName'];
            $logos[$i] = $logo;
            $i++;
        }
        return $logos;
    }

    public function FindOneLogo()
    {
        $SQL = "Select * from logos where LogoId = " . $this->LogoId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $logo = new Logo();
            $logo->LogoId = $row['LogoId'];
            $logo->Activated = $row['Activated'];
            $logo->Image = $row['Image'];
            $logo->Name = $row['Name'];
            $logo->LatinName = $row['LatinName'];
            return $logo;
        }
    }

    public function getLogoId()
    {
        $SQL = "Select LogoId from logos where '%" . $this->Name . "%' = (Name + ' | ' + LatinName) Limit 1 ";
        echo $SQL;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['LogoId'];
        }
    }

}
