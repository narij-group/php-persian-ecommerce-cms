<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {


        $smds = new SubMenuDataSource();
        $smds->open();

        $submenu = new SubMenu();
        $_POST['image'] = str_replace('/DigitalShopV1/SubMenuImages//', 'SubMenuImages/', $_POST['image']);
        $submenu->Image = $_POST['image'];
        $submenu->SubGroup = $_POST['subgroup'];
        $submenu->SubMenuId = $_POST['id'];
        $s = $smds->FindOneSubMenuBasedOnId($_POST['id']);
        $submenu->MainMenu = $_POST['mainmenu'];
        $submenu->Number = $s->Number;


        $smds->Update($submenu);
        $smds->close();


    } else {


        $smds = new SubMenuDataSource();
        $smds->open();

        $submenu = new SubMenu();
        $_POST['image'] = str_replace('/DigitalShopV1/SubMenuImages//', 'SubMenuImages/', $_POST['image']);
        $submenu->Image = $_POST['image'];
        $submenu->Name = $_POST['name'];
        $submenu->MainMenu = $_POST['mainmenu'];
        $submenu->SubGroup = $_POST['subgroup'];
        $submenu->Number = $smds->MaxNumber() + 1;
        if ($smds->MaxNumber() == null) {
            $submenu->Number = 1;
        }
        $smds->Insert($submenu);
        $smds->close();

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

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

}
header('Location:SubMenus.php');




