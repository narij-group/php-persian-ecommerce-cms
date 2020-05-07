<?php
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';

$purchasebasket = new PurchaseBasket();
$price = new PriceDataSource();
$price->open();
$purchasebasket->Product = $_GET['id'];
// $purchasebasket->Count = $_GET['count'];
$purchasebasket->Date = date("Y/m/d");
$purchasebasket->Price = $price->GetLastPriceForOneProduct($purchasebasket->Product);
if (!isset($_COOKIE[COOKIE_CUSTOMER_ID]) || $_COOKIE[COOKIE_CUSTOMER_ID] == 0) {
    $_SESSION[SESSION_STRING_CART_ERROR] = "برای خرید ابتدا وارد حساب خود شوید .";
    header("Location:../Post.php?id=$purchasebasket->Product");
}
$purchasebasket->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];

$pbds = new PurchaseBasketDataSource();
$pbds->open();
$pbds->Insert($purchasebasket);
$pbds->close();
$price->close();
header("Location:../Purchase.php");
