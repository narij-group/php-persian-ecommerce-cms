<?php
require_once 'Template/top2.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';
$glds = new GuaranteeListDataSource();
$glds->open();
$guaranteelist = new GuaranteeList();
$guaranteelist->GuaranteeListId = $_POST['id'];
$guaranteelist->Name = $_POST['name'];
$guaranteelist->Duration = $_POST['duration'];
$_POST['price'] = str_replace(',', '', $_POST['price']);
$guaranteelist->Price = $_POST['price'];
$glds->Update($guaranteelist);
$glds->close();
header('Location:GuaranteeLists.php');
