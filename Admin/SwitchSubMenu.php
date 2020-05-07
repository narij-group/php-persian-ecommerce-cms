<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';

$smds = new SubMenuDataSource();
$smds->open();

$SubMenu = new SubMenu();
$SubMenu = $smds->FindOneSubMenuBasedOnId($_GET["id"]);
if ($SubMenu->Disabled == 0) {
    $SubMenu->Disabled = 1;
} else {
    $SubMenu->Disabled = 0;
}
$smds->SwitchStatus($SubMenu);
$smds->close();
header('Location:SubMenus.php');
