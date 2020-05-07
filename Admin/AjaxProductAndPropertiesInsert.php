<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

//echo "saddasdsadasd";

$papds = new ProductAndPropertyDataSource();
$papds->open();
$productAndProperty = new  ProductAndProperty();
$productAndProperty->Product = $_POST['product'];

for ($i = 0; isset($_POST["field$i"]); $i++) {
    if (trim($_POST["field$i"]) != "") {
        if ($papds->doesPPExist(intval($_POST["fieldname$i"]), $_POST['product']) != 0) {
            $productAndProperty2 = new ProductAndProperty();
            $productAndProperty2->ProductAndPropertyId = $papds->doesPPExist(intval($_POST["fieldname$i"]), $_POST['product']);
            $productAndProperty2->ProductProperty->ProductPropertyId = intval($_POST["fieldname$i"]);
            $productAndProperty2->Product = $_POST['product'];
            $productAndProperty2->Value = $_POST["field$i"];
            $papds->Update($productAndProperty2);

        } else {
            $productAndProperty->ProductProperty->ProductPropertyId = intval($_POST["fieldname$i"]);
            $productAndProperty->Value = $_POST["field$i"];
            $papds->Insert($productAndProperty);
        }
    } else {
        if ($papds->doesPPExist(intval($_POST["fieldname$i"]), $_POST['product']) != 0) {
            $productAndProperty2 = new ProductAndProperty();
            $productAndProperty2->ProductAndPropertyId = $productAndProperty->doesPPExist(intval($_POST["fieldname$i"]), $_POST['product']);
            $papds->Delete($productAndProperty2->ProductAndPropertyId);
        }
    }
}
$papds->close();


