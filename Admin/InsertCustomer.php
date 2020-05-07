<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
$customer = new Customer();
$customer->Name = $_POST['name'];
$customer->Family = $_POST['family'];
$customer->Username = $_POST['username'];
$customer->Password = md5($_POST['password']);
$customer->Email = $_POST['email'];
$customer->Address = $_POST['address'];
$customer->City = $_POST['city'];
$customer->NationalityCode = $_POST['nationalitycode'];
$customer->Estate = $_POST['estate'];
$customer->Mobile = $_POST['mobile'];
$customer->Phone = $_POST['phone'];
$customer->PostCode = $_POST['postcode'];

$cds = new CustomerDataSource();
$cds->open();
$cds->Insert($customer);
$cds->close();
header('Location:Customers.php');
