<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
session_start();

$cds = new CustomerDataSource();
$cds->open();

$customer = new Customer();
$customer->CustomerId = $_POST['id'];
$ccc = $cds->FindOneCustomerBasedOnId($_POST['id']);
$customers = $cds->Fill();
$e = "";
foreach ($customers as $c) {
    if ($_POST['email'] == $c->Email && $_POST['email'] != $ccc->Email) {
        $e = 'yes';
    } else if ($e != "yes") {
        $e = 'no';
    }
    if ($_POST['username'] == $c->Username && $_POST['username'] != $ccc->Username) {
        $e2 = 'yes';
    } else if ($e != "yes") {
        $e2 = 'no';
    }
}
$customer->Name = $_POST['name'];
$customer->Family = $_POST['family'];
$customer->Email = $_POST['email'];
$customer->Username = $_POST['username'];
$customer->Address = $_POST['address'];
$customer->City = $_POST['city'];
$customer->NationalityCode = $_POST['nationalitycode'];
$customer->Estate = $_POST['estate'];
$customer->PostCode = $_POST['postcode'];
$customer->Mobile = $_POST['mobile'];
$customer->Phone = $_POST['phone'];
if (isset($_POST['repeatpass'])) {
    if ($_POST['repeatpass'] == $_POST['password']) {
        $_SESSION[SESSION_STRING_MESSAGE] = "";
    } else {
        $_SESSION[SESSION_STRING_MESSAGE] = "PassMatchE()";
    }
} else {
    $_SESSION[SESSION_STRING_MESSAGE] = "PassMatchE()";
}
if (trim($_POST['repeatpass']) == "" && trim($_POST['password']) == "") {
    $customer->Password = $ccc->Password;
} else {
    $customer->Password = md5($_POST['password']);
}
$customer2 = $cds->FindOneCustomerBasedOnId($customer->CustomerId);
if ($customer2->Password == $_POST['password']) {
    $customer->Password = $_POST['password'];
} else {
    $customer->Password = md5($_POST['password']);
}

if (isset($e)) {
    if ($e == 'yes') {
        $_SESSION[SESSION_STRING_MESSAGE] = "EmailE()";
    } else if ($_SESSION[SESSION_STRING_MESSAGE] == "") {
        $_SESSION[SESSION_STRING_MESSAGE] = "";
    }
    if ($e2 == 'yes') {
        $_SESSION[SESSION_STRING_MESSAGE] = "UsernameE()";
    } else if ($_SESSION[SESSION_STRING_MESSAGE] == "") {
        $_SESSION[SESSION_STRING_MESSAGE] = "";
    }
}
if ($_SESSION[SESSION_STRING_MESSAGE] == "") {
    $cds->Update($customer);
    $cds->close();

    header('location:../UserProfile.php');
} else {
    header('location:../index.php?id=' . $_POST['id']);
}