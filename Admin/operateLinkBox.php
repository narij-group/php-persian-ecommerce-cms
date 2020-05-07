<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
        $lds = new LinkBoxDataSource();
        $lds->open();
        $linkbox = new LinkBox();
        $linkbox->LinkBoxId = $_POST['id'];
        $linkbox->Name = $_POST['name'];
        $linkbox->Link = $_POST['link'];
        $linkbox->LinkboxTitle = $_POST['linkboxtitle'];
        $lds->Update($linkbox);
        $lds->close();
    } else {
        $lds = new LinkBoxDataSource();
        $lds->open();
        $linkbox = new LinkBox();
        $linkbox->Name = $_POST['name'];
        $linkbox->Link = $_POST['link'];
        $linkbox->LinkboxTitle = $_POST['linkboxtitle'];
        $linkbox->User = $_POST['user'];
        $lds->Insert($linkbox);
        $lds->close();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteLinkBox != 1) {
        header('Location:Index.php');
        die();
    }

    $lds = new LinkBoxDataSource();
    $lds->open();
    $lds->Delete($_GET['id']);
    $lds->close();
}
header('Location:LinkBoxes.php');