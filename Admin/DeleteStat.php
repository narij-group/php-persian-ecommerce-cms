<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->Stats != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
$stat = new StatDataSource();
$stat->open();
$stats = $stat->FindOneStatBasedOnId($_GET['id']);
$stat->Delete($_GET['id']);
$stat->close();
if (!isset($_POST['pid'])) {
    header('Location:Stats.php');
} else {
    header('Location:Stats.php?id=' . $_POST['pid']);
}