<?php

require_once 'DataAccess.inc';
require_once 'Group.inc';

class MainMenu
{

    public $MainMenuId;
    public $Group;
    public $Number;
    public $Disabled;

    public function __construct()
    {
        $this->MainMenuId = 0;
        $this->Group = new Group();
        $this->Number = 0;
        $this->Disabled = 0;
    }

    public function Insert()
    {
        $SQL = "Insert Into mainmenus(`Group`,`Number`,`Disabled`) Values (" . $this->Group . " ," . $this->Number . "," . $this->Disabled . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update mainmenus Set `Group` = " . $this->Group . ",`Number` = " . $this->Number . ",`Disabled` = " . $this->Disabled . " Where MainMenuId=" . $this->MainMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function SwitchStatus() {
        $SQL = "Update mainmenus Set `Disabled`=" . $this->Disabled . " Where MainMenuId=" . $this->MainMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function UpdateNum()
    {
        $SQL = "Update mainmenus Set `Number` = " . $this->Number . " Where MainMenuId=" . $this->MainMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From mainmenus Where MainMenuId = " . $this->MainMenuId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group` ORDER BY Number";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $mainmenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $mainmenu = new MainMenu();
            $mainmenu->MainMenuId = $row['MainMenuId'];
            $mainmenu->Group->GroupId = $row['GroupId'];
            $mainmenu->Group->Name = $row['Name'];
            $mainmenu->Number = $row['Number'];
            $mainmenu->Disabled = $row['Disabled'];
            $mainmenus[$i] = $mainmenu;
            $i++;
        }
        return $mainmenus;
    }

    public function CFill()
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group` WHERE Disabled = 0 ORDER BY Number";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $mainmenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $mainmenu = new MainMenu();
            $mainmenu->MainMenuId = $row['MainMenuId'];
            $mainmenu->Group->GroupId = $row['GroupId'];
            $mainmenu->Group->Name = $row['Name'];
            $mainmenu->Number = $row['Number'];
            $mainmenu->Disabled = $row['Disabled'];
            $mainmenus[$i] = $mainmenu;
            $i++;
        }
        return $mainmenus;
    }

    public function getRecordsAfter()
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group`  WHERE `Number` > " . $this->Number . "";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $mainmenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $mainmenu = new MainMenu();
            $mainmenu->MainMenuId = $row['MainMenuId'];
            $mainmenu->Group->GroupId = $row['GroupId'];
            $mainmenu->Group->Name = $row['Name'];
            $mainmenu->Disabled = $row['Disabled'];
            $mainmenu->Number = $row['Number'];
            $mainmenus[$i] = $mainmenu;
            $i++;
        }
        return $mainmenus;
    }

    public function FindByNum($num1)
    {
        $SQL = "Select * from mainmenus WHERE `Number` = " . $num1;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $mainmenu = new MainMenu();
            $mainmenu->MainMenuId = $row['MainMenuId'];
            $mainmenu->Group = $row['Group'];
            $mainmenu->Number = $row['Number'];
            $mainmenu->Disabled = $row['Disabled'];
            return $mainmenu;
        }
    }

    public function MaxNumber()
    {
        $Id = "SELECT MAX(Number) from mainmenus INNER JOIN groups on GroupId = `Group` ";
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(Number)'];
        }
    }

    public function FindOneMainMenu()
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group`  where MainMenuId = " . $this->MainMenuId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $mainmenu = new MainMenu();
            $mainmenu->MainMenuId = $row['MainMenuId'];
            $mainmenu->Group->GroupId = $row['GroupId'];
            $mainmenu->Group->Name = $row['Name'];
            $mainmenu->Number = $row['Number'];
            $mainmenu->Disabled = $row['Disabled'];
            return $mainmenu;
        }
    }

}
