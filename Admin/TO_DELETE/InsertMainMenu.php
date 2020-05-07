<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mmds = new MainMenuDataSource();
$mmds->open();

$mainmenu = new MainMenu();
$mainmenu->Group = $_POST['group'];
$mainmenu->Number = $mmds->MaxNumber() + 1;
if ($mmds->MaxNumber() == null) {
    $mainmenu->Number = 1;
}

$mmds->Insert($mainmenu);
$mmds->close();
header('Location:MainMenus.php');
