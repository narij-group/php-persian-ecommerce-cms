<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PanelDataSource.inc';
date_default_timezone_set("Asia/Tehran");
$dateNow = date_create();

$pds = new PanelDataSource();
$pds->open();
$panel = new Panel();
$panel->Name = $_POST['name'];
$panel->Email = $_POST['email'];
$panel->Mobile = $_POST['mobile'];
$panel->Content = $_POST['content'];
$panel->Date = $dateNow->format("Y/m/d");
$pds->Insert($panel);
header("location:PanelRequest.php?status=OK");
