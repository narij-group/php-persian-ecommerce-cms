<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {



        $suppermenu = new SupperMenu();
        $suppermenu->SupperMenuId = $_POST['id'];
        $suppermenu->SubMenu = $_POST['submenu'];
        $suppermenu->SupperGroup = $_POST['suppergroup'];
        $suppermenu->Title = $_POST['title'];
        $suppermenu->MainMenu = $_POST['mainmenu'];

        $sds = new SupperMenuDataSource();
        $sds->open();
        $sds->Update($suppermenu);
        $sds->close();



    } else {

        $suppermenu = new SupperMenu();
        $suppermenu->SubMenu = $_POST['submenu'];
        $suppermenu->SupperGroup = $_POST['suppergroup'];
        $suppermenu->Title = $_POST['title'];
        $suppermenu->MainMenu = $_POST['mainmenu'];

        $smds = new SupperMenuDataSource();
        $smds->open();
        $smds->Insert($suppermenu);
        $smds->close();
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $suppermenu = new SupperMenuDataSource();
    $suppermenu->open();
    $suppermenu->Delete($_GET['id']);
    $suppermenu->close();
}

header('Location:SupperMenus.php');