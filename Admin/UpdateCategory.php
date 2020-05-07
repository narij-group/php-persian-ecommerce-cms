<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';
$category = new Category();
$category->CategoryId = $_POST['id'];
$category->Name = $_POST['name'];
$category->Description = $_POST['description'];
$category->Parent = $_POST['parent'];

$cds = new CategoryDataSource();
$cds->open();
$cds->Update($category);
$cds->close();

header('Location:Categories.php');
