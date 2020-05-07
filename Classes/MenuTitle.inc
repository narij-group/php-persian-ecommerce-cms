<?php

require_once 'DataAccess.inc';
require_once 'SubMenu.inc';

class MenuTitle {

    public $MenuTitleId;
    public $Name;
    public $SubMenu;
    public $Column;

    public function __construct() {
        $this->MenuTitleId = 0;
        $this->Name = "";
        $this->SubMenu = new SubMenu();
        $this->Column = 0;
    }

    public function Insert() {
        $SQL = "Insert Into menutitles(Name,SubMenu,`Column`) Values ('" . $this->Name . "' , " . $this->SubMenu . " , " . $this->Column . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update menutitles Set `Name` = '" . $this->Name . "',SubMenu = " . $this->SubMenu . ",`Column` = " . $this->Column . " Where MenuTitleId=" . $this->MenuTitleId . "";                
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From menutitles Where MenuTitleId = " . $this->MenuTitleId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column`,submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }
    public function getOneSubMenuTitles() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where submenus.SubMenuId = " . $this->SubMenu;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }
    public function getOneSubMenuTitlesC1() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 1 AND submenus.SubMenuId = " . $this->SubMenu;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }
    public function getOneSubMenuTitlesC2() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 2 AND submenus.SubMenuId = " . $this->SubMenu;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }
    public function getOneSubMenuTitlesC3() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 3 AND submenus.SubMenuId = " . $this->SubMenu;

        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }
    public function getOneSubMenuTitlesC4() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 4 AND submenus.SubMenuId = " . $this->SubMenu;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menutitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            $menutitles[$i] = $menutitle;
            $i++;
        }
        return $menutitles;
    }

    public function GetTitle($titleId) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where menutitles.MenuTitleId = " . $titleId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Name'];
        }
    }

    public function FindOneMenuTitle() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column`,submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where MenuTitleId = " . $this->MenuTitleId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $menutitle = new MenuTitle();
            $menutitle->MenuTitleId = $row['MenuTitleId'];
            $menutitle->Name = $row['Name'];
            $menutitle->Column = $row['Column'];
            $menutitle->SubMenu->SubMenuId = $row['SubMenuId'];
            $menutitle->SubMenu->SubGroup = $row['SubMenuName'];
            $menutitle->SubMenu->Image = $row['Image'];
            return $menutitle;
        }
    }

}
