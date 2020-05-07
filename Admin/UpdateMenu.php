<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
$menu = new Menu();
$menu->MenuId = $_POST['id'];
$menu->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
if (trim($_POST['mainmenu']) == "" || trim($_POST['submenu']) == "" || trim($_POST['suppermenu']) == "") {
    $product->MainMenu = $product2->MainMenu->MainMenuId;
    $product->SubMenu = $product2->SubMenu->SubMenuId;
    $product->SupperMenu = $product2->SupperMenu->SupperMenuId;
} else {
    $product->MainMenu = $_POST['mainmenu'];
    $product->SubMenu = $_POST['submenu'];
    $product->SupperMenu = $_POST['suppermenu'];
}
$mds = new MenuDataSource();
$mds->open();
$mds->Update($menu);
$mds->close();
if (!isset($_POST['pid'])) {
    header('Location:Menus.php');
} else {
    header('Location:Menus.php?id=' . $_POST['pid']);
}

