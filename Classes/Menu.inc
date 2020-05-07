<?php

require_once 'DataAccess.inc';
require_once 'MainMenu.inc';
require_once 'SubMenu.inc';
require_once 'SupperMenu.inc';

class Menu {

    public $MenuId;
    public $SupperMenu;
    public $SubMenu;
    public $MainMenu;
    public $Product;

    public function __construct() {
        $this->MenuId = 0;
        $this->SupperMenu = new SupperMenu();
        $this->SubMenu = new SubMenu();
        $this->MainMenu = new MainMenu();
        $this->Product = 0;
    }

    public function Insert() {

        $SQL = "Insert Into menus(`SupperMenu`,SubMenu,MainMenu,Product) Values (" . $this->SupperMenu . "," . $this->SubMenu . " , " . $this->MainMenu . ", " . $this->Product . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update menus Set `SupperMenu`=" . $this->SupperMenu . ",SubMenu=" . $this->SubMenu . ", MainMenu=" . $this->MainMenu . ", Product=" . $this->Product . " Where MenuId=" . $this->MenuId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From menus Where MenuId= " . $this->MenuId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneMenu() {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId Where MenuId=" . $this->MenuId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $menu = new Menu();
            $menu->MenuId = $row['MenuId'];
            $menu->Product = $row['Product'];
            $menu->MainMenu->MainMenuId = $row['MainMenuId'];
            $menu->MainMenu->Name = $row['MainMenuName'];
            $menu->SubMenu->SubMenuId = $row['SubMenuId'];
            $menu->SubMenu->SubMenuName = $row['SubMenuName'];
            $menu->SubMenu->MainMenu = $row['MainMenu'];
            $menu->SubMenu->Image = $row['Image'];
            $menu->SupperMenu->MainMenu = $row['SPMainMenu'];
            $menu->SupperMenu->SubMenu = $row['SPSubMenu'];
            $menu->SupperMenu->Name = $row['SPName'];
            $menu->SupperMenu->Title = $row['SPTitle'];
            return $menu;
        }
    }

    public function GetMenusForOneProduct($productId) {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId Where menus.Product=" . $productId;
        $db = new DataAccess();
        $menus = array();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menu = new Menu();
            $menu->MenuId = $row['MenuId'];
            $menu->Product = $row['Product'];
            $menu->MainMenu->MainMenuId = $row['MainMenuId'];
            $menu->MainMenu->Name = $row['MainMenuName'];
            $menu->SubMenu->SubMenuId = $row['SubMenuId'];
            $menu->SubMenu->SubMenuName = $row['SubMenuName'];
            $menu->SubMenu->MainMenu = $row['MainMenu'];
            $menu->SubMenu->Image = $row['Image'];
            $menu->SupperMenu->MainMenu = $row['SPMainMenu'];
            $menu->SupperMenu->SubMenu = $row['SPSubMenu'];
            $menu->SupperMenu->Name = $row['SPName'];
            $menu->SupperMenu->Title = $row['SPTitle'];
            $menus[$i] = $menu;
            $i++;
        }
        return $menus;
    }

    public function Fill() {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menu = new Menu();
            $menu->MenuId = $row['MenuId'];
            $menu->Product = $row['Product'];
            $menu->MainMenu->MainMenuId = $row['MainMenuId'];
            $menu->MainMenu->Name = $row['MainMenuName'];
            $menu->SubMenu->SubMenuId = $row['SubMenuId'];
            $menu->SubMenu->SubMenuName = $row['SubMenuName'];
            $menu->SubMenu->MainMenu = $row['MainMenu'];
            $menu->SubMenu->Image = $row['Image'];
            $menu->SupperMenu->MainMenu = $row['SPMainMenu'];
            $menu->SupperMenu->SubMenu = $row['SPSubMenu'];
            $menu->SupperMenu->Name = $row['SPName'];
            $menu->SupperMenu->Title = $row['SPTitle'];
            $menus[$i] = $menu;
            $i++;
        }
        return $menus;
    }

    public function FindOneSubMenuProducts() {
        //(Select Sum(Quantity) from productcolors where Product = Products.ProductId) as Quantity ORDER BY Quantity =0, ProductId DESC 
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu, (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where menus.SubMenu = " . $this->SubMenu ."  ORDER BY Quantity =0, menus.Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }

    public function FindOneSupperMenuProducts() {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where menus.SupperMenu = " . $this->SupperMenu ."  ORDER BY Quantity =0, menus.Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }

    public function FindOneTitleProducts() {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where suppermenus.title = " . $this->SupperMenu->Title ."  ORDER BY Quantity =0, menus.Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }
}
