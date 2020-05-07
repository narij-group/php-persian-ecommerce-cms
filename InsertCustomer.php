<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';
session_start();
$cds = new CustomerDataSource();
$cds->open();
$customer = new Customer();
$customers = $cds->Fill();
$e = "";
$_SESSION[SESSION_STRING_MESSAGE] = "";
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
//$customer->Phone = $_POST['phone'];
//$customer->Username = $_POST['username'];
$customer->Username = $_POST['email'];;
//$customer->Mobile = $_POST['mobile'];
//$customer->Address = $_POST['address'];
//$customer->PostCode = $_POST['postcode'];
//$customer->City = $_POST['city'];
$customer->NationalityCode = $_POST['nationalitycode'];
//$customer->Estate = $_POST['estate'];
if (isset($_POST['repeatpass'])) {
    if ($_POST['repeatpass'] == $_POST['password']) {

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

    }
}
if ($cds->IsUsernameAllowed($customer->Username) == 1) {

} else {
    $_SESSION[SESSION_STRING_MESSAGE] = "UsernameE()";
}
if ($_SESSION[SESSION_STRING_MESSAGE] == "") {
    $cds->Insert($customer);
    if ($cds->IsCustomerAllowed($customer) == TRUE) {
        $c2 = $cds->FindOneCustomerWithEmail($customer);
        setcookie(COOKIE_CUSTOMER_ID, $c2->CustomerId, time() + 86400);


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
        $pbds = new PurchaseBasketDataSource();
        $pbds->open();
        $pbds->updatePurchaseBasketsCustomer($c2->CustomerId, session_id());
        $pbds->updatePurchaseBasketsCustomerFroExistingBaskets($c2->CustomerId, session_id());
        $pbds->close();


        $_SESSION[SESSION_YES_NO_CUSTOMER_LOGGED_IN] = "YES";
        setcookie(COOKIE_CUSTOMER_LOGGED_IN, "YES", time() + 86400);
        $_SESSION[SESSION_STRING_CART_ERROR] = "";
    }
    $_SESSION[SESSION_STRING_MESSAGE] = "RSuccess()";
    $cds->close();
    header('location:' . $_POST['link']);
} else {
    header('location:' . $_POST['link']);
}