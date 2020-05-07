<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteGuarantee != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';
$guaranteelist = new GuaranteeListDataSource();
$guaranteelist->open();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
$g = $guaranteelist->FindOneGuaranteeListBasedOnId($_GET['id']);
$pg = new GuaranteeDataSource();
$pg->open();
$temp = $pg->GetThisGuaranteeProducts($_GET['id']);
foreach ($temp as $item) {
    $pg->Delete($item->GuaranteeId);
}
$pg->close();
$guaranteelist->Delete($_GET['id']);
$guaranteelist->close();
header('Location:GuaranteeLists.php');
