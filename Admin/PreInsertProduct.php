<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$pds = new ProductDataSource();
$pds->open();

$product = new Product();
$product1 = new Product();
$product->Name = $_POST['name'];
$_POST['content'] = str_replace('<p>', '', $_POST['content']);
if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
    $_POST['review'] = str_replace('/DigitalShopV1/', '', $_POST['review']);
    $_POST['content'] = str_replace('/DigitalShopV1/', '', $_POST['content']);
    $_POST['review'] = str_replace('../', '', $_POST['review']);
    $_POST['content'] = str_replace('../', '', $_POST['content']);
} else {
    $_POST['review'] = str_replace('http://', '', $_POST['review']);
    $_POST['content'] = str_replace('http://', '', $_POST['content']);
}
$_POST['content'] = str_replace('</p>', '', $_POST['content']);
$product->Description = $pds->mres($_POST['content']);
$product->User = $_POST['user'];
$product->LatinName = $_POST['latinname'];
$product->Category = $_POST['category'];
$product->Brand = $_POST['brand'];
$_POST['review'] = str_replace('<p>', '', $_POST['review']);
$_POST['review'] = str_replace('</p>', '', $_POST['review']);
$product->Review = $pds->mres($_POST['review']);

$pds->Insert($product);
//-----------------------------------------------
$_SESSION[SESSION_INT_PRODUCT_ID] = $pds->MaxId();
$maxId = $pds->MaxId();
echo $_SESSION[SESSION_INT_PRODUCT_ID];

$pds->close();

//-----------------------------------------------
if (file_exists("../Images/$maxId") == false) {
    mkdir("../Images/$maxId");
}
header('Location:ProductImage.php');
