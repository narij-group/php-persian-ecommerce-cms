<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';

$stat = new Stat();
$stat->StatId = $_POST['id'];
$stat->Visit = $_POST['visit'];

$sds = new StatDataSource();
$sds->open();
$sds->Update($stat);
$sds->close();
if (!isset($_POST['pid'])) {
    header('Location:Stats.php');
} else {
    header('Location:Stats.php?id=' . $_POST['pid']);
}

