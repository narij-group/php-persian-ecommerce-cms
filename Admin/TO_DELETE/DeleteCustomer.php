<?php

//TODO OPTIMISED - NOt TESTED

require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteCustomer != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';


//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
//$cm = new CommentDataSource();
//$cm->open();
//$temp = $cm->GetThisCustomerComments($_GET['id']);
//foreach ($temp as $item) {
//    $cm->Delete($item->CommentId);
//}
//$cm->close();
//
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
//$o = new OpinionDataSource();
//$o->open();
//$temp = $o->GetThisCustomerOpinions($_GET['id']);
//foreach ($temp as $item) {
//    $o->Delete($item->OpinionId);
//}
//$o->close();
//
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
//$fp = new FactorProductDataSource();
//$fp->open();
//$temp = $fp->FindOneCustomerFactors2($_GET['id']);
//foreach ($temp as $item) {
//    $fp->Delete($item->FactorProductId);
//}
//$fp->close();
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorDataSource.inc';
//$f = new FactorDataSource();
//$f->open();
//$temp = $f->GetOneCustomerFactors($_GET['id']);
//foreach ($temp as $item) {
//    $f->Delete($item->FactorId);
//}
//$f->close();
//
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
//$p = new PurchaseBasketDataSource();
//$p->open();
//$temp = $p->FindSomeonePurchaseBasket($_GET['id']);
//foreach ($temp as $item) {
//    $p->Delete($item->PurchaseBasketId);
//}
//$p->close();
//
//
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
//$u = new UserCouponDataSource();
//$u->open();
//$temp = $u->FindOneUserCoupons($_GET['id']);
//foreach ($temp as $item) {
//    $u->Delete($item->UserCouponId);
//}
//$u->close();

//$cds = new CustomerDataSource();
//$cds->open();
//$cds->Delete($_GET['id']);
//$cds->close();


$cds = new CustomerDataSource();
$cds->open();
$cds->K_Delete($_GET['id']);
$cds->close();


header('Location:Customers.php');
