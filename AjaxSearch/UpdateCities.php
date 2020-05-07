<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/CityDataSource.inc';
$city = new CityDataSource();
$city ->open();
$cities = $city->GetOneProvinceCities($_POST['province']);

if($_POST['province'] == 0){
    echo "<option value='0' >";
    echo 'انتخاب شهر...';
    echo '</option>';
}
foreach ($cities as $ct) {
    echo "<option value='$ct->CityId' >";
    echo $ct->Name;
    echo '</option>';    
}
?>