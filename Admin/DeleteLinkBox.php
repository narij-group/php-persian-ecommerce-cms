<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteLinkBox != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
$lds = new LinkBoxDataSource();
$lds->open();
$lds->Delete($_GET['id']);
$lds->close();
header('Location:LinkBoxes.php');