<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteFeed != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';
$fds = new FeedDataSource();
$fds->open();
$fds->Delete($_GET['id']);
$fds->close();
header('Location:Feeds.php');
