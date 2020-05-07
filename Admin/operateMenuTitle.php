<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
        $menutitle = new MenuTitle();
        $menutitle->MenuTitleId = $_POST['id'];
        $menutitle->Name = $_POST['name'];
        $menutitle->SubMenu = $_POST['submenu'];
        $menutitle->Column = $_POST['column'];

        $mds = new MenuTitleDataSource();
        $mds->open();
        $mds->Update($menutitle);
        $mds->close();
        header('Location:MenuTitles.php');



    } else {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';

        $menutitle = new MenuTitle();
        $menutitle->Name = $_POST['name'];
        $menutitle->SubMenu = $_POST['submenu'];
        $menutitle->Column = $_POST['column'];

        $mds = new MenuTitleDataSource();
        $mds->open();
        $mds->Insert($menutitle);
        $mds->close();
        header('Location:MenuTitles.php');

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
    require_once 'Template/top2.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
    $menutitle = new MenuTitleDataSource();
    $menutitle->open();
    $menutitle->Delete($_GET['id']);
    $menutitle->close();
    header('Location:MenuTitles.php');

}




