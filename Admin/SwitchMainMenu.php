<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mmds = new MainMenuDataSource();
$mmds->open();

$MainMenu = new MainMenu();
$MainMenu = $mmds->FindOneMainMenuBasedOnId($_GET["id"]);
if ($MainMenu->Disabled == 0) {
    $MainMenu->Disabled = 1;
} else {
    $MainMenu->Disabled = 0;
}
$mmds->SwitchStatus($MainMenu);
$mmds->close();
header('Location:MainMenus.php');
