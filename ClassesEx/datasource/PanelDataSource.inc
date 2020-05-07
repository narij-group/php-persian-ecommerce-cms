<?php
date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Panel.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class PanelDataSource
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

    public function Insert(Panel $panel)
    {
        $SQL = "Insert Into panels(`Name`,Mobile,Email,Content,Date) Values('" . $panel->getName() . "' , '" . $panel->getMobile() . "' , '" . $panel->getEmail() . "' , '" . $panel->getContent() . "' , '" . $panel->getDate() . "')";
        return $this->da->exec($SQL);
    }

    public function Update(Panel $panel)
    {
        $SQL = "Update panels Set `Name`=" . $panel->getName() . " , Mobile='" . $panel->getMobile() . "' , Email='" . $panel->getEmail() . "' , Content='" . $panel->getContent() . "' , Date='" . $panel->getDate() . "' Where PanelId=" . $panel->PanelId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From panels Where PanelId = " . $id;
        $this->da->exec($SQL);
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(PanelId) from panels";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(PanelId)'];
        }
    }

    public function Fill()
    {
        $SQL = "Select * from panels";
        $results = $this->da->execSelect($SQL);
        $panels = array();
        while ($row = mysqli_fetch_array($results)) {
            $panel = new Panel();
            $panel->setPanelId($row['PanelId']);
            $panel->setName($row['Name']);
            $panel->setMobile($row['Mobile']);
            $panel->setEmail($row['Email']);
            $panel->setContent($row['Content']);
            $panel->setDate($row['Date']);
            $panels[] = $panel;
        }
        return $panels;
    }


    public function FindOnePanelBasedOnId($id)
    {
        $SQL = "Select * from panels where PanelId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $panel = new Panel();
            $panel->setPanelId($row['PanelId']);
            $panel->setName($row['Name']);
            $panel->setMobile($row['Mobile']);
            $panel->setEmail($row['Email']);
            $panel->setContent($row['Content']);
            $panel->setDate($row['Date']);
            return $panel;
        }
    }


}
