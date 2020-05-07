<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/MenuTitle.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class MenuTitleDataSource {

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

    public function Insert(MenuTitle $menuTitle) {
        $SQL = "Insert Into menutitles(Name,SubMenu,`Column`) Values ('" . $menuTitle->Name . "' , " . $menuTitle->SubMenu . " , " . $menuTitle->Column . ")";
        return $this->da->exec($SQL);
    }

    public function Update(MenuTitle $menuTitle) {
        $SQL = "Update menutitles Set `Name` = '" . $menuTitle->Name . "',SubMenu = " . $menuTitle->SubMenu . ",`Column` = " . $menuTitle->Column . " Where MenuTitleId=" . $menuTitle->MenuTitleId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From menutitles Where MenuTitleId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill() {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column`,submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId ";
        $results = $this->da->execSelect($SQL);
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
    public function getOneSubMenuTitles($SubMenuId) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where submenus.SubMenuId = " . $SubMenuId;
        $results = $this->da->execSelect($SQL);
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
    public function getOneSubMenuTitlesC1($SubMenuID) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 1 AND submenus.SubMenuId = " . $SubMenuID;
        $results = $this->da->execSelect($SQL);
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
    public function getOneSubMenuTitlesC2($SubMenuId) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 2 AND submenus.SubMenuId = " . $SubMenuId;
        $results = $this->da->execSelect($SQL);
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
    public function getOneSubMenuTitlesC3($SubMenuID) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 3 AND submenus.SubMenuId = " . $SubMenuID;

        $results = $this->da->execSelect($SQL);
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
    public function getOneSubMenuTitlesC4($SubMenuId) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column` , submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where `Column` = 4 AND submenus.SubMenuId = " . $SubMenuId;
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Name'];
        }
    }

    public function FindOneMenuTitleBasedOnId($id) {
        $SQL = "Select menutitles.MenuTitleId , menutitles.Name, `Column`,submenus.SubMenuId , submenus.SubGroup as SubMenuName , submenus.Image  from menutitles  Inner Join submenus On menutitles.SubMenu = submenus.SubMenuId where MenuTitleId = " . $id;
        $results = $this->da->execSelect($SQL);
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
