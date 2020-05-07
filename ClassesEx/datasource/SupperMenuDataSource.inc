<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/SupperMenu.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SupperMenuDataSource
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

    public function Insert(SupperMenu $supperMenu)
    {
        $SQL = "Insert Into suppermenus(`SupperGroup`,SubMenu,Title,MainMenu) Values (" . $supperMenu->SupperGroup . "," . $supperMenu->SubMenu . " , " . $supperMenu->Title . " , " . $supperMenu->MainMenu . ")";
        $this->da->exec($SQL);
    }

    public function Update(SupperMenu $supperMenu)
    {
        $SQL = "Update suppermenus Set `SupperGroup`=" . $supperMenu->SupperGroup . ",SubMenu=" . $supperMenu->SubMenu . " , Title=" . $supperMenu->Title . ", MainMenu=" . $supperMenu->MainMenu . " Where SupperMenuId=" . $supperMenu->SupperMenuId . "";
        //echo $SQL;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From suppermenus Where SupperMenuId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneSupperMenuBasedOnId($id)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where SupperMenuId=" . $id;
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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

    public function getOneSubMenuSupperMenus($subMenuId)
    {
        $SQL = "Select suppermenus.SupperMenuId , suppergroups.SupperGroupId , suppergroups.Name as SupperGroupName , menutitles.MenuTitleId , menutitles.Name as TitleName , menutitles.SubMenu as TitleSubMenu ,submenus.MainMenu , submenus.SubGroup as SubGroupName , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId , mainmenus.Group as GroupName From `suppermenus` INNER JOIN suppergroups on SupperGroupId = SupperGroup Inner Join mainmenus On suppermenus.MainMenu = mainmenus.MainMenuId Inner Join submenus On suppermenus.SubMenu = submenus.SubMenuId Inner Join menutitles On suppermenus.Title = menutitles.MenuTitleId Where suppermenus.SubMenu =" . $subMenuId . "  ORDER  BY SupperGroupName ASC ";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
