<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/MainMenu.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class MainMenuDataSource
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

    public function Insert(MainMenu $mainMenu)
    {
        $SQL = "Insert Into mainmenus(`Group`,`Number`,`Disabled`) Values (" . $mainMenu->Group . " ," . $mainMenu->Number . "," . $mainMenu->Disabled . ")";
        $this->da->exec($SQL);
    }

    public function Update(MainMenu $mainMenu)
    {
        $SQL = "Update mainmenus Set `Group` = " . $mainMenu->Group . ",`Number` = " . $mainMenu->Number . ",`Disabled` = " . $mainMenu->Disabled . " Where MainMenuId=" . $mainMenu->MainMenuId . "";
        $this->da->exec($SQL);
    }

    public function SwitchStatus(MainMenu $mainMenu)
    {
        $SQL = "Update mainmenus Set `Disabled`=" . $mainMenu->Disabled . " Where MainMenuId=" . $mainMenu->MainMenuId . "";
        $this->da->exec($SQL);
    }

    public function UpdateNum(MainMenu $mainMenu)
    {
        $SQL = "Update mainmenus Set `Number` = " . $mainMenu->Number . " Where MainMenuId=" . $mainMenu->MainMenuId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From mainmenus Where MainMenuId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group` ORDER BY Number";
        $results = $this->da->execSelect($SQL);
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
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
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

    public function getRecordsAfter($number)
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group`  WHERE `Number` > " . $number . "";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(Number)'];
        }
    }

    public function FindOneMainMenuBasedOnId($id)
    {
        $SQL = "Select * from mainmenus INNER JOIN groups on GroupId = `Group`  where MainMenuId = " . $id;
        $results = $this->da->execSelect($SQL);
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
