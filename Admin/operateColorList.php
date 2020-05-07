<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $colorlist = new ColorList();
        $colorlist->ColorListId = $_POST['id'];
        $colorlist->Name = $_POST['name'];
        $colorlist->Sample = $_POST['sample'];


        $clsd = new ColorListDataSource();
        $clsd->open();
        $clsd->Update($colorlist);
        $clsd->close();


    } else {

        $colorlist = new ColorList();
        $colorlist->Name = $_POST['name'];
        $colorlist->Sample = $_POST['sample'];
        $clds = new ColorListDataSource();
        $clds->open();
        $clds->Insert($colorlist);
        $clds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    if ($role->DeleteColor != 1) {
        header('Location:Index.php');
        die();
    }

    $colorlist = new ColorListDataSource();
    $colorlist->open();
    $colorlist->K_Delete($_GET['id']);
    $colorlist->close();

}
header('Location:ColorLists.php');





