<?php

//TODO OPTIMISED - NOt TESTED

require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteProduct != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$pds = new ProductDataSource();
$pds->open();

$selected_product = $pds->FindOneProductBasedOnId($_GET['id']);
if ($selected_product->Sells == 0) {

    $pds->K_Delete($_GET['id']);

//    $pds->DeleteFolder("../Images/{$_GET['id']}");
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
//    $prds = new PriceDataSource();
//    $prds->open();
//    $prices = $prds->GetPricesForOneProduct($_GET['id']);
//    foreach ($prices as $p) {
//        $prds->Delete($p->PriceId);
//    }
//    $prds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
//    $pbds = new PurchaseBasketDataSource();
//    $pbds->open();
//    $pbs = $pbds->GetProducts($_GET['id']);
//    foreach ($pbs as $bp) {
//        $pbds->Delete($bp->PurchaseBasketId);
//    }
//    $pbds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
//    $grds = new GuaranteeDataSource();
//    $grds->open();
//    $guarantees = $grds->GetGuaranteesForOneProduct($_GET['id']);
//    foreach ($guarantees as $g) {
//        $grds->Delete($g->GuaranteeId);
//    }
//    $grds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
//    $pcds = new ProductColorDataSource();
//    $pcds->open();
//
//    $pColors = $pcds->GetProductColorsForOneProduct($_GET['id']);
//    foreach ($pColors as $pc) {
//        $pcds->Delete($pc->ProductColorId);
//    }
//    $pcds->close();
////$pCoupons = $pCoupon->FindOneProductCoupons($product->ProductId);
////foreach ($pCoupons as $pcc) {
////    $pcc->Delete();
////}
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
//    $stds = new StatDataSource();
//    $stds->open();
//    $stats = $stds->GetStatsForOneProduct($_GET['id']);
//    foreach ($stats as $s) {
//        $stds->Delete($s->StatId);
//    }
//    $stds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
//    $mnds = new MenuDataSource();
//    $mnds->open();
//
//    $menus = $mnds->GetMenusForOneProduct($_GET['id']);
//    foreach ($menus as $m) {
//        $mnds->Delete($m->MenuId);
//    }
//    $mnds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
//    $opds = new OpinionDataSource();
//    $opds->open();
//    $opinions = $opds->GetOpinionsForProduct($_GET['id']);
//    foreach ($opinions as $o) {
//        $opds->Delete($o->OpinionId);
//    }
//    $opds->close();
//
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
//    $cmds = new CommentDataSource();
//    $cmds->open();
//    $comments = $cmds->GetCommentsForProduct($_GET['id']);
//    foreach ($comments as $c) {
//        $cmds->Delete($c->CommentId);
//    }
//    $cmds->close();
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
//    $dsds = new DiscountDataSource();
//    $dsds->open();
//    $discounts = $dsds->GetDiscountsForOneProduct($_GET['id']);
//    foreach ($discounts as $d) {
//        $dsds->Delete($d->DiscountId);
//    }
//    $dsds->close();
//
//    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
//    $ppds = new ProductAndPropertyDataSource();
//    $ppds->open();
//    $paps = $ppds->GetPropertiesForOneProduct($_GET['id']);
//    foreach ($paps as $p) {
//        $ppds->Delete($p->ProductAndPropertyId);
//    }
//    $ppds->close();
//
//    $pds->Delete($_GET['id']);


} else {
    $pds->Deactivate($_GET['id']);
}
$pds->close();

header('Location:Products.php');
