<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

$papds = new ProductAndPropertyDataSource();
$papds->open();
$productAndProperty = new ProductAndProperty();
$productAndProperty->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
for ($i = 0; isset($_POST["field$i"]); $i++) {
    $productAndProperty->ProductProperty->ProductPropertyId = intval($_POST["fieldname$i"]);
    $productAndProperty->Value = $_POST["field$i"];
    if (trim($productAndProperty->Value) != "") {
        if ($papds->doesPPExist($productAndProperty->ProductProperty->ProductPropertyId, $_SESSION[SESSION_INT_PRODUCT_ID]) != 0) {
            $productAndProperty2 = new ProductAndProperty();
            $productAndProperty2->ProductAndPropertyId = $productAndProperty->doesPPExist($productAndProperty->ProductProperty->ProductPropertyId, $_SESSION[SESSION_INT_PRODUCT_ID]);
            $productAndProperty2->ProductProperty->ProductPropertyId = intval($_POST["fieldname$i"]);
            $productAndProperty2->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
            $productAndProperty2->Value = $_POST["field$i"];
            $papds->Update($productAndProperty2);
        } else {
            $papds->Insert($productAndProperty);
        }
    }
}
$papds->close();
header('Location:ProductAndProperties.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
