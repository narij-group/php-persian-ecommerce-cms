<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
$submenu = new SubMenuDataSource();
$submenu->open();
$submenus = $submenu->FindOneSubMenuBasedOnId($_GET['id']);
$number = $submenu->Number;

if (file_exists("../" . $submenus->Image)) {
    unlink('../' . $submenus->Image);
}


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
$title = new MenuTitleDataSource();
$title->open();
$titles = $title->getOneSubMenuTitles($_GET['id']);
foreach ($titles as $t) {
    $title->Delete($t->MenuTitleId);
}
$title->close();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenus = $suppermenu->getOneSubMenuSupperMenus($_GET['id']);
foreach ($suppermenus as $spmnu) {
    $suppermenu->Delete($spmnu->SupperMenuId);
}
$suppermenu->close();

$submenu->Delete($_GET['id']);

$submenu2 = new SubMenu();
$submenu2->Number = $number;
$submenus2 = $submenu->getRecordsAfter($submenu2);

foreach ($submenus2 as $mm) {
    $mm->Number = $mm->Number - 1;
    $submenu->UpdateNum($mm);
}

$submenu->close();
header('Location:SubMenus.php');
