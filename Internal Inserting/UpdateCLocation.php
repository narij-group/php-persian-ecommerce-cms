<?php
if (!isset($_SESSION))
    session_start();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$customer = new Customer();
$customer->CustomerId = $_POST['id'];
$customer->Estate = $_POST['estate'];
$customer->City = $_POST['city'];

if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
//    $_SESSION[SESSION_EARLY_CUSTOMER__CITY_DATA] = $_POST['city'];
} else {
    $_SESSION[SESSION_EARLY_CUSTOMER__CITY_DATA] = $_POST['city'];
}


$cds = new CustomerDataSource();
$cds->open();
$cds->UpdateLocation($customer);
$cds->close();