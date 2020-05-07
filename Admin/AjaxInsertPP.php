<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
$pp = new ProductProperty();
$pp->Group = $_POST['group'];
$pp->Name = $_POST['name'];
$pp->Value = $_POST['value'];
$ppds = new ProductPropertyDataSource();
$ppds->open();
$ppds->Insert($pp);
$ppds->close();