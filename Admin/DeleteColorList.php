<?php

//TODO OPTIMISED - NOt TESTED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteColor != 1) {
    header('Location:Index.php');
    die();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';

//$colorlist = new ColorListDataSource();
//$colorlist->open();
//$c = $colorlist->FindOneColorListBasedOnId($_GET['id']);
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
//$pcolor = new ProductColorDataSource();
//$pcolor->open();
//$temp = $pcolor->GetProductsOfColor($c->ColorListId);
//foreach ($temp as $t) {
//    $pcolor->Delete($t->ProductColorId);
//}
//
//
//
//$pcolor->close();


$colorlist = new ColorListDataSource();
$colorlist->open();
$colorlist->K_Delete($_GET['id']);
$colorlist->close();
header('Location:ColorLists.php');
