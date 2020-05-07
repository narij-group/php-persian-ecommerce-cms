<?php

require_once 'DataAccess.inc';
require_once 'MainMenu.inc';
require_once 'SubGroup.inc';

class SubMenu
{

    public $SubMenuId;
    public $SubGroup;
    public $Image;
    public $MainMenu;
    public $Number;
    public $Disabled;

    public function __construct()
    {
        $this->SubMenuId = 0;
        $this->Number = 0;
        $this->Disabled = 0;
        $this->SubGroup = new SubGroup();
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->MainMenu = new MainMenu();
    }

    public function Insert()
    {
        $SQL = "Insert Into submenus(`SubGroup`,Image,MainMenu,`Number`,`Disabled`) Values (" . $this->SubGroup . ",'" . $this->Image . "' , " . $this->MainMenu . ", " . $this->Number . ", " . $this->Disabled . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update submenus Set `SubGroup`=" . $this->SubGroup . ",Image='" . $this->Image . "', MainMenu=" . $this->MainMenu . ", `Number`=" . $this->Number . ", `Disabled`=" . $this->Disabled . " Where SubMenuId=" . $this->SubMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function SwitchStatus() {
        $SQL = "Update submenus Set `Disabled`=" . $this->Disabled . " Where SubMenuId=" . $this->SubMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function UpdateNum()
    {
        $SQL = "Update submenus Set `Number`=" . $this->Number . " Where SubMenuId=" . $this->SubMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From submenus Where SubMenuId= " . $this->SubMenuId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneSubMenu()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId Where SubMenuId=" . $this->SubMenuId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
            return $submenu;
        }
    }

    public function Fill()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId ORDER BY submenus.Number ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    public function getOneMainMenuSubMenus()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId where submenus.MainMenu =" . $this->MainMenu . " AND submenus.Disabled = 0 ORDER BY submenus.Number ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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


    public function getRecordsAfter()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId WHERE submenus.Number > " . $this->Number . "";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function getBySubgroup()
    {
        $SQL = "Select submenus.SubMenuId,submenus.Disabled , submenus.SubGroup , subgroups.Name as SubGroupName, subgroups.SubGroupId , submenus.Image, submenus.Number , mainmenus.MainMenuId , mainmenus.Group From `submenus` INNER JOIN subgroups on subgroups.SubGroupId = submenus.SubGroup Inner Join mainmenus On submenus.MainMenu = mainmenus.MainMenuId WHERE submenus.SubGroup = " . $this->SubGroup . "";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(Number)'];
        }
    }


}
