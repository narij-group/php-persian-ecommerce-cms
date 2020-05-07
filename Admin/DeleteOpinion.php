<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteOpinion != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
$opds = new OpinionDataSource();
$opds->open();
$opds->Delete($_GET['id']);
$opds->close();
header('Location:Opinions.php');