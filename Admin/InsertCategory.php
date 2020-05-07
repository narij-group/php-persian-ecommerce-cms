<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';
$category = new Category();
$category->Name = $_POST['name'];
$category->Description = $_POST['description'];
$category->Parent = $_POST['parent'];
$category->User = $_POST['user'];
$cds = new CategoryDataSource();
$cds->open();
$cds->Insert($category);
$cds->close();
header('Location:Categories.php');
