<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmnu = $mainmenu->FindOneMainMenuBasedOnId($_GET['id']);
$number = $mainmnu->Number;


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
$title = new MenuTitleDataSource();
$title->open();
$submenu = new SubMenuDataSource();
$submenu->open();
$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$submenus = $submenu->getOneMainMenuSubMenus($_GET['id']);
foreach ($submenus as $smnu) {

    $titles = $title->getOneSubMenuTitles($smnu->SubMenuId);
    foreach ($titles as $t) {
        $title->Delete($t->MenuTitleId);
    }

    $suppermenus = $suppermenu->getOneSubMenuSupperMenus($smnu->SubMenuId);
    foreach ($suppermenus as $spmnu) {
        $suppermenu->Delete($spmnu->SupperMenuId);
    }
    $submenu->Delete($smnu->SubMenuId);
}
$title->close();
$submenu->close();
$suppermenu->close();

$mainmenu->Delete($_GET['id']);
$mainmenu->close();

$mainmenuu2 = new MainMenuDataSource();
$mainmenuu2->open();
$mainmenus2 = $mainmenuu2->getRecordsAfter($number);
foreach ($mainmenus2 as $mm) {
    $mm->Number = $mm->Number - 1;
    $mainmenuu2->UpdateNum($mm);
}
$mainmenuu2->close();
header('Location:MainMenus.php');
