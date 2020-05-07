<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';
require_once 'Template/top2.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
        $lds = new LinkboxTitleDataSource();
        $lds->open();
        $linkboxtitle = new LinkboxTitle();
        $linkboxtitle->LinkboxTitleId = $_POST['id'];
        $linkboxtitle->Name = $_POST['name'];
        $lds->Update($linkboxtitle);
        $lds->close();
    } else {
        $lds = new LinkboxTitleDataSource();
        $lds->open();
        $linkboxtitle = new LinkboxTitle();
        $linkboxtitle->Name = $_POST['name'];
        $lds->Insert($linkboxtitle);
        $lds->close();
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->LinkBoxGroup != 1) {
        header('Location:Index.php');
        die();
    }
    $ltds = new LinkboxTitleDataSource();
    $ltds->open();
    $ltds->K_Delete($_GET['id']);
    $ltds->close();
}
header('Location:LinkboxTitles.php');




