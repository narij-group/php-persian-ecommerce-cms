<?php

require_once 'DataAccess.inc';
require_once 'MainMenu.inc';
require_once 'SubMenu.inc';
require_once 'SupperGroup.inc';
require_once 'MenuTitle.inc';

class SupperMenu
{

    public $SupperMenuId;
    public $SupperGroup;
    public $Title;
    public $SubMenu;
    public $MainMenu;

    public function __construct()
    {
        $this->SupperMenuId = 0;
        $this->SupperGroup = new SupperGroup();
        $this->Title = new MenuTitle();
        $this->SubMenu = new SubMenu();
        $this->MainMenu = new MainMenu();
    }

    public function Insert()
    {
        $SQL = "Insert Into suppermenus(`SupperGroup`,SubMenu,Title,MainMenu) Values (" . $this->SupperGroup . "," . $this->SubMenu . " , " . $this->Title . " , " . $this->MainMenu . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update suppermenus Set `SupperGroup`=" . $this->SupperGroup . ",SubMenu=" . $this->SubMenu . " , Title=" . $this->Title . ", MainMenu=" . $this->MainMenu . " Where SupperMenuId=" . $this->SupperMenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From suppermenus Where SupperMenuId= " . $this->SupperMenuId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneSupperMenu()
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where SupperMenuId=" . $this->SupperMenuId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            return $suppermenu;
        }
    }

    public function Fill()
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Order by suppermenus.SupperMenuId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getOneSubMenuSupperMenus()
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where suppermenus.SubMenu =" . $this->SubMenu . "  ORDER  BY SupperGroupName ASC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getSupperMenusOfThisTitle($title)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId where menutitles.MenuTitleId = '$title' ORDER  BY SupperGroupName ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getSupperMenusOfThisTitleC1($title)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where `Column` = 1 AND  menutitles.MenuTitleId = '$title' ORDER  BY SupperGroupName ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getSupperMenusOfThisTitleC2($title)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where `Column` = 2 AND  menutitles.MenuTitleId = '$title' ORDER  BY SupperGroupName ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getSupperMenusOfThisTitleC3($title)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where `Column` = 3 AND  menutitles.MenuTitleId = '$title' ORDER BY SupperGroupName ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

    public function getSupperMenusOfThisTitleC4($title)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where `Column` = 4 AND  menutitles.MenuTitleId = '$title' ORDER  BY SupperGroupName ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $suppermenus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $suppermenu = new SupperMenu();
            $suppermenu->SupperMenuId = $row['SupperMenuId'];
            $suppermenu->SupperGroup->Name = $row['SupperGroupName'];
            $suppermenu->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $suppermenu->MainMenu->MainMenuId = $row['MainMenuId'];
            $suppermenu->MainMenu->Group = $row['GroupName'];
            $suppermenu->Title->MenuTitleId = $row['MenuTitleId'];
            $suppermenu->Title->SubMenu = $row['TitleSubMenu'];
            $suppermenu->Title->Name = $row['TitleName'];
            $suppermenu->SubMenu->SubGroup = $row['SubGroupName'];
            $suppermenu->SubMenu->SubMenuId = $row['SubMenuId'];
            $suppermenu->SubMenu->MainMenu = $row['MainMenu'];
            $suppermenu->SubMenu->Image = $row['Image'];
            $suppermenus[$i] = $suppermenu;
            $i++;
        }
        return $suppermenus;
    }

}
