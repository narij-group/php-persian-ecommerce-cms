<?php
//TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
$customer = new Customer();
$cds = new CustomerDataSource();
$cds->open();

$customer->CustomerId = $_POST['customer'];
$c = $cds->FindOneCustomerBasedOnId($_POST['customer']);
$product = (string)$_POST['product'];
if ($_POST['action'] == 'existance') {
    $customer->RequestedProducts = $c->RequestedProducts . ',' . $product;
    if (strpos($c->RequestedProducts, $product) == false) {
        $cds->UpdateRequests($customer);
    }
} elseif ($_POST['action'] == 'specialoffer') {
    $customer->SRequestedProducts = $c->SRequestedProducts . ',' . $product;
    if (strpos($c->SRequestedProducts, $product) == false) {
        $cds->UpdateSRequests($customer);
    }
}


