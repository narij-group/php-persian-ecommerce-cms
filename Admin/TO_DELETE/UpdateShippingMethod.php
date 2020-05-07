<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingMethodDataSource.inc';
$smds = new ShippingMethodDataSource();
$smds->open();

$shippingmethod = new ShippingMethod();
$shippingmethod->ShippingMethodId = $_POST["id"];
$shippingmethod->Name = $_POST["name"];
$_POST['price'] = str_replace( ',' , '' , $_POST['price'] );
$shippingmethod->Price = $_POST["price"];
$_POST['image'] = str_replace( '/DigitalShopV1/ShippingMethodImages//' , 'ShippingMethodImages/' , $_POST['image'] );
$shippingmethod->Image = $_POST["image"];
$shippingmethod->Comment = $_POST["comment"];

if($_POST["special"] == 1 ){
    $city_ids = array_unique(explode(",", $_POST['allowedcities']));
    $cities = "";
    $i = 0;
    foreach ($city_ids as $c) {
        if($i != 0){
            $cities .= ',';
        }
        if($c != ""){
            $cities .= $c;
            $i++;
        }
    }
    $shippingmethod->AllowedCities = $cities;
} else {
    $shippingmethod->AllowedCities = "";
}

$shippingmethod->Activated = $_POST["activated"];
$smds->Update($shippingmethod);
$smds->close();

//$shippingmethod->Update();
header('Location:ShippingMethods.php');
