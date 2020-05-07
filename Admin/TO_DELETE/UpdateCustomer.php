<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$cds = new CustomerDataSource();
$cds->open();


$customer = new Customer();
$customer->CustomerId = $_POST['id'];
$customer2 = $cds->FindOneCustomerBasedOnId($_POST['id']);
$customer->Name = $_POST['name'];
$customer->Family = $_POST['family'];
$customer->Username = $_POST['username'];
//$customer->Password = md5($_POST['password']);
if ($customer2->Password == $_POST['password']) {
    $customer->Password = $_POST['password'];
} else {
    $customer->Password = md5($_POST['password']);
}
$customer->Email = $_POST['email'];
$customer->Address = $_POST['address'];
$customer->City = $_POST['city'];
$customer->NationalityCode = $_POST['nationalitycode'];
$customer->Estate = $_POST['estate'];
$customer->Mobile = $_POST['mobile'];
$customer->Phone = $_POST['phone'];
$customer->PostCode = $_POST['postcode'];

$cds->Update($customer);
$cds->close();
header('Location:Customers.php');
