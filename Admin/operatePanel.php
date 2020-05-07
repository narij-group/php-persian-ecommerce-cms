<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PanelDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->EditPanel != 1) {
        header('Location:Index.php');
        die();
    }

    $pds = new PanelDataSource();
    $pds->open();
    $pds->Delete($_GET['id']);
    $pds->close();
}
header('Location:Panels.php');