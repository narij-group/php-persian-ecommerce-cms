<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
$menu = new Menu();
$menu->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$menu->MainMenu = $_POST['mainmenu'];
$menu->SubMenu = $_POST['submenu'];
if (trim($_POST['suppermenu']) == "") {
    $menu->SupperMenu = 0;
} else {
    $menu->SupperMenu = $_POST['suppermenu'];
}

$mds = new MenuDataSource();
$mds->open();
$mds->Insert($menu);
$mds->close();
header('Location:Menus.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
