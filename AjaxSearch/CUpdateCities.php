<?php
if (!isset($_SESSION))
    session_start();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
$city = new CityDataSource();
$city->open();
$cities = $city->GetOneProvinceCities($_POST['province']);

if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
//    $_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA] = $_POST['province'];
} else {
    $_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA] = $_POST['province'];
}


echo "<option value='0' >";
echo 'انتخاب شهر...';
echo '</option>';
foreach ($cities as $ct) {
    echo "<option value='$ct->CityId' >";
    echo $ct->Name;
    echo '</option>';
}
?>