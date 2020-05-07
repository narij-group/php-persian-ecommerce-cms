<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Menu.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class MenuDataSource
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

    public function Insert(Menu $menu)
    {

        $SQL = "Insert Into menus(`SupperMenu`,SubMenu,MainMenu,Product) Values (" . $menu->SupperMenu . "," . $menu->SubMenu . " , " . $menu->MainMenu . ", " . $menu->Product . ")";
        $this->da->exec($SQL);
    }

    public function Update(Menu $menu)
    {
        $SQL = "Update menus Set `SupperMenu`=" . $menu->SupperMenu . ",SubMenu=" . $menu->SubMenu . ", MainMenu=" . $menu->MainMenu . ", Product=" . $menu->Product . " Where MenuId=" . $menu->MenuId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From menus Where MenuId= " . $id;
        $this->da->exec($SQL);
    }


    public function DeleteMenusRelatedToProduct($productId)
    {
        $SQL = "Select `menus`.* From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId Where menus.Product=" . $productId;
        $this->da->exec($SQL);
    }


    public function FindOneMenuBasedOnId($id)
    {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId Where MenuId=" . $id;
        $results = $this->da->execSelect($SQL);
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

    public function GetMenusForOneProduct($productId)
    {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId Where menus.Product=" . $productId;
        $results = $this->da->execSelect($SQL);
//        echo $SQL;
        $menus = array();
        $i = 0;
        if ($results != false) {
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
        }
        return $menus;
    }

    public function Fill()
    {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId";
        $results = $this->da->execSelect($SQL);
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

    public function FindOneSubMenuProducts(Menu $menu)
    {
        //(Select Sum(Quantity) from productcolors where Product = Products.ProductId) as Quantity ORDER BY Quantity =0, ProductId DESC 
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu, (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where menus.SubMenu = " . $menu->SubMenu . "  ORDER BY Quantity =0, menus.Product DESC";
        $results = $this->da->execSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }

    public function FindOneSupperMenuProducts(Menu $menu)
    {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where menus.SupperMenu = " . $menu->SupperMenu . "  ORDER BY Quantity =0, menus.Product DESC";
        $results = $this->da->execSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }

    public function FindOneTitleProducts(Menu $menu)
    {
        $SQL = "Select menus.MenuId , menus.Product ,submenus.MainMenu , submenus.Image , (Select Sum(Quantity) from productcolors where Product = menus.Product) as Quantity , submenus.SubMenuId , mainmenus.MainMenuId, mainmenus.Name as MainMenuName , submenus.Name as SubMenuName ,suppermenus.SupperMenuId , suppermenus.MainMenu as SPMainMenu, suppermenus.SubMenu as SPSubMenu, suppermenus.Title as SPTitle , suppermenus.Name as SPName From `menus` Inner Join mainmenus On menus.MainMenu = mainmenus.MainMenuId Inner Join submenus On menus.SubMenu = submenus.SubMenuId Inner Join suppermenus On menus.SupperMenu = suppermenus.SupperMenuId where suppermenus.title = " . $menu->SupperMenu->Title . "  ORDER BY Quantity =0, menus.Product DESC";
        $results = $this->da->execSelect($SQL);
        $menus = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $menus[$i] = $row['Product'];
            $i++;
        }
        return $menus;
    }
}
