<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

session_start();
$customer = new Customer();
$cds = new CustomerDataSource();
$cds->open();
$customers = $cds->Fill();
$e = "";
foreach ($customers as $c) {
    if ($_POST['email'] == $c->Email) {
        $e = 'yes';
    } else if ($e != "yes") {
        $e = 'no';
    }
}
$customer->Name = $_POST['name'];
$customer->Family = $_POST['family'];
$customer->Password = md5($_POST['password']);
$customer->Email = $_POST['email'];
$customer->Phone = $_POST['phone'];
$customer->Username = $_POST['username'];
$customer->Mobile = $_POST['mobile'];
$customer->Address = $_POST['address'];
$customer->PostCode = $_POST['postcode'];
$customer->City = $_POST['city'];
$customer->NationalityCode = $_POST['nationalitycode'];
$customer->Estate = $_POST['estate'];
if (isset($_POST['repeatpass'])) {
    if ($_POST['repeatpass'] == $_POST['password']) {
        $_SESSION[SESSION_STRING_MESSAGE] = "";
    } else {
        $_SESSION[SESSION_STRING_MESSAGE] = "PassMatchE()";
    }
} else {
    $_SESSION[SESSION_STRING_MESSAGE] = "PassMatchE()";
}
if (isset($e)) {
    if ($e == 'yes') {
        $_SESSION[SESSION_STRING_MESSAGE] = "EmailE()";
    } else if ($_SESSION[SESSION_STRING_MESSAGE] == "") {
        $_SESSION[SESSION_STRING_MESSAGE] = "";
    }
}
if ($cds->IsUsernameAllowed($customer->Username) == 1) {
    $_SESSION[SESSION_STRING_MESSAGE] = "";
} else {
    $_SESSION[SESSION_STRING_MESSAGE] = "UsernameE()";
}
if ($_SESSION[SESSION_STRING_MESSAGE] == "" && $_POST['username'] != "admin") {


    $cds->Insert($customer);

    if ($cds->IsCustomerAllowed($customer) == TRUE) {
        $c2 = $cds->FindOneCustomerWithEmail($customer);
        setcookie(COOKIE_CUSTOMER_ID, $c2->CustomerId, time() + 86400);
        $_SESSION[SESSION_YES_NO_CUSTOMER_LOGGED_IN] = "YES";
        setcookie(COOKIE_CUSTOMER_LOGGED_IN, "YES", time() + 86400);
        $_SESSION[SESSION_STRING_CART_ERROR] = "";
    }
    $_SESSION[SESSION_STRING_MESSAGE] = "RSuccess()";
    header('location:' . $_POST['link']);
} else {
    header('location:' . $_POST['link']);
}