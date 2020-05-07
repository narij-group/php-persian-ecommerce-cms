<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductPropertyDataSource.inc";

$pp = new ProductPropertyDataSource();
$pp->open();
$pp->UpdateSearch($_POST["id"], $_POST["search_value"]);
$pp->close();