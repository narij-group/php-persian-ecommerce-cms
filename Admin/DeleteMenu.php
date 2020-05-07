<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
$menu = new MenuDataSource();
$menu->open();
$menu->MenuId = $_GET['id'];
$menu->Delete($_GET['id']);
$menu->close();
if (!isset($_GET['pid'])) {
    header('Location:Menus.php');
} else {
    header('Location:Menus.php?id=' . $_GET['pid']);
}

