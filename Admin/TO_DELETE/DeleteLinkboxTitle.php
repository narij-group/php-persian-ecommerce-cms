<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->LinkBoxGroup != 1) {
    header('Location:Index.php');
    die();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
$ltds = new LinkboxTitleDataSource();
$lds = new LinkBoxDataSource();
$ltds->open();
$lds->open();

$linkboxtitle = new LinkboxTitle();
$linkbox = new LinkBox();
$linkboxes = $lds->GetOneTitleLinks($_GET['id']);
foreach ($linkboxes as $lb) {
    $lds->Delete($lb->LinkBoxId);
}
$ltds->Delete($_GET['id']);

$ltds->close();
$lds->close();

header('Location:LinkboxTitles.php');
