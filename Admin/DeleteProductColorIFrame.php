<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ProductColorDataSource.inc';
$productcolor = new ProductColorDataSource();
$productcolor ->open();
$productcolor->Delete($_GET['id']);
$productcolor ->close();
if (!isset($_GET['pid'])) {
    header('Location:ProductColorsIFrame.php');
} else {
    header('Location:ProductColorsIFrame.php?id=' . $_GET['pid']);
}
