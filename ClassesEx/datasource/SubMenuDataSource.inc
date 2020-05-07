<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/SubMenu.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SubMenuDataSource
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

    public function Insert(SubMenu $subMenu)
    {
        $SQL = "Insert Into submenus(`SubGroup`,Image,MainMenu,`Number`,`Disabled`) Values (" . $subMenu->SubGroup . ",'" . $subMenu->Image . "' , " . $subMenu->MainMenu . ", " . $subMenu->Number . ", " . $subMenu->Disabled . ")";
        $this->da->exec($SQL);
    }

    public function Update(SubMenu $subMenu)
    {
        $SQL = "Update submenus Set `SubGroup`=" . $subMenu->SubGroup . ",Image='" . $subMenu->Image . "', MainMenu=" . $subMenu->MainMenu . ", `Number`=" . $subMenu->Number . ", `Disabled`=" . $subMenu->Disabled . " Where SubMenuId=" . $subMenu->SubMenuId . "";
        $this->da->exec($SQL);
    }

    public function SwitchStatus(SubMenu $subMenu)
    {
        $SQL = "Update submenus Set `Disabled`=" . $subMenu->Disabled . " Where SubMenuId=" . $subMenu->SubMenuId . "";
        $this->da->exec($SQL);
    }

    public function UpdateNum(SubMenu $subMenu)
    {
        $SQL = "Update submenus Set `Number`=" . $subMenu->Number . " Where SubMenuId=" . $subMenu->SubMenuId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From submenus Where SubMenuId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneSubMenuBasedOnId($id)
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId Where SubMenuId=" . $id;
//        echo $SQL . "<br>";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->SubGroup->Name = $row['SubGroupName'];
//            echo $submenu->SubGroup->Name;
//            echo $row['SubGroupName'];
            $submenu->SubGroup->SubGroupId = $row['SubGroupId'];
//            echo $row['SubGroupId'];
            $submenu->Image = $row['Image'];
            $submenu->Number = $row['Number'];
            $submenu->Disabled = $row['Disabled'];

            $submenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $submenu->MainMenu->Group = $row['Group'];
            return $submenu;
        }
        return null;
    }

    public function Fill()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId ORDER BY submenus.Number ASC";
        $results = $this->da->execSelect($SQL);
        $submenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->SubGroup->Name = $row['SubGroupName'];
            $submenu->SubGroup->SubGroupId = $row['SubGroupId'];
            $submenu->Image = $row['Image'];
            $submenu->Number = $row['Number'];
            $submenu->Disabled = $row['Disabled'];

            $submenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $submenu->MainMenu->Group = $row['Group'];

            $submenus[$i] = $submenu;
            $i++;
        }
        return $submenus;
    }

    public function getOneMainMenuSubMenus($mainMenuId)
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId where submenus.MainMenu =" . $mainMenuId . " AND submenus.Disabled = 0 ORDER BY submenus.Number ASC";
        $results = $this->da->execSelect($SQL);
        $submenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->SubGroup->Name = $row['SubGroupName'];
            $submenu->SubGroup->SubGroupId = $row['SubGroupId'];
            $submenu->Image = $row['Image'];
            $submenu->Number = $row['Number'];
            $submenu->Disabled = $row['Disabled'];

            $submenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $submenu->MainMenu->Group = $row['Group'];

            $submenus[$i] = $submenu;
            $i++;
        }
        return $submenus;
    }


    public function getRecordsAfter(SubMenu $subMenu)
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId WHERE submenus.Number > " . $subMenu->Number . "";
        $results = $this->da->execSelect($SQL);
        $submenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->SubGroup->Name = $row['SubGroupName'];
            $submenu->SubGroup->SubGroupId = $row['SubGroupId'];
            $submenu->Image = $row['Image'];
            $submenu->Number = $row['Number'];
            $submenu->Disabled = $row['Disabled'];

            $submenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $submenu->MainMenu->Group = $row['Group'];

            $submenus[$i] = $submenu;
            $i++;
        }
        return $submenus;
    }

    public function getBySubgroup(SubMenu $subMenu)
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId WHERE submenus.SubGroup = " . $subMenu->SubGroup . "";
        $results = $this->da->execSelect($SQL);
        $submenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->SubGroup->Name = $row['SubGroupName'];
            $submenu->SubGroup->SubGroupId = $row['SubGroupId'];
            $submenu->Image = $row['Image'];
            $submenu->Number = $row['Number'];
            $submenu->Disabled = $row['Disabled'];

            $submenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $submenu->MainMenu->Group = $row['Group'];

            $submenus[$i] = $submenu;
            $i++;
        }
        return $submenus;
    }

    public function FindByNum($num1)
    {
        $SQL = "Select submenus.SubMenuId,submenus.Number From `submenus` WHERE submenus.Number = " . $num1;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $submenu = new SubMenu();
            $submenu->SubMenuId = $row['SubMenuId'];
            $submenu->Number = $row['Number'];
            return $submenu;
        }
    }

    public function MaxNumber()
    {
        $Id = "SELECT MAX(Number) from submenus";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(Number)'];
        }
    }

    public function ExistSubMenuForMainMenu($mainmenu)
    {
        $SQL = "Select * From submenus WHERE MainMenu = '$mainmenu'";
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}
