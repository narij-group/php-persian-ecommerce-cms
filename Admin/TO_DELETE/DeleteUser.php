<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteUser != 1) {
    header('Location:Index.php');
    die();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';
$uds = new UserDataSource();
$uds->open();
$uds->Delete($_GET['id']);
$uds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
$dsds = new DiscountDataSource();
$dsds->open();
$temp = $dsds->GetThisUserDiscounts($_GET['id']);
foreach ($temp as $t) {
    $dsds->Delete($t->DiscountId);
}
$dsds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$pcds = new PriceDataSource();
$pcds->open();
$temp = $pcds->GetThisUserPrices($_GET['id']);
foreach ($temp as $t) {
    $pcds->Delete($t->PriceId);
}
$pcds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
$nwds = new NewsDataSource();
$temp = $nwds->GetThisUserNews($_GET['id']);
foreach ($temp as $t) {
    $nwds->Delete($t->NewsId);
}
$nwds->close();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$fpds = new ProductDataSource();
$temp = $fpds->GetThisUserProducts($_GET['id']);
foreach ($temp as $item) {


    $pds->DeleteFolder("../Images/{$item->ProductId}");

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
    $prds = new PriceDataSource();
    $prds->open();
    $prices = $prds->GetPricesForOneProduct($item->ProductId);
    foreach ($prices as $p) {
        $prds->Delete($p->PriceId);
    }
    $prds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
    $pbds = new PurchaseBasketDataSource();
    $pbds->open();
    $pbs = $pbds->GetProducts($item->ProductId);
    foreach ($pbs as $bp) {
        $pbds->Delete($bp->PurchaseBasketId);
    }
    $pbds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
    $grds = new GuaranteeDataSource();
    $grds->open();
    $guarantees = $grds->GetGuaranteesForOneProduct($item->ProductId);
    foreach ($guarantees as $g) {
        $grds->Delete($g->GuaranteeId);
    }
    $grds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
    $pcds = new ProductColorDataSource();
    $pcds->open();

    $pColors = $pcds->GetProductColorsForOneProduct($item->ProductId);
    foreach ($pColors as $pc) {
        $pcds->Delete($pc->ProductColorId);
    }
    $pcds->close();
//$pCoupons = $pCoupon->FindOneProductCoupons($product->ProductId);
//foreach ($pCoupons as $pcc) {
//    $pcc->Delete();
//}

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
    $stds = new StatDataSource();
    $stds->open();
    $stats = $stds->GetStatsForOneProduct($item->ProductId);
    foreach ($stats as $s) {
        $stds->Delete($s->StatId);
    }
    $stds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
    $mnds = new MenuDataSource();
    $mnds->open();

    $menus = $mnds->GetMenusForOneProduct($item->ProductId);
    foreach ($menus as $m) {
        $mnds->Delete($m->MenuId);
    }
    $mnds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
    $opds = new OpinionDataSource();
    $opds->open();
    $opinions = $opds->GetOpinionsForProduct($item->ProductId);
    foreach ($opinions as $o) {
        $opds->Delete($o->OpinionId);
    }
    $opds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
    $cmds = new CommentDataSource();
    $cmds->open();
    $comments = $cmds->GetCommentsForProduct($item->ProductId);
    foreach ($comments as $c) {
        $cmds->Delete($c->CommentId);
    }
    $cmds->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
    $dsds = new DiscountDataSource();
    $dsds->open();
    $discounts = $dsds->GetDiscountsForOneProduct($item->ProductId);
    foreach ($discounts as $d) {
        $dsds->Delete($d->DiscountId);
    }
    $dsds->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
    $ppds = new ProductAndPropertyDataSource();
    $ppds->open();
    $paps = $ppds->GetPropertiesForOneProduct($item->ProductId);
    foreach ($paps as $p) {
        $ppds->Delete($p->ProductAndPropertyId);
    }
    $ppds->close();


    $fpds->Delete($item->ProductId);
}


header('Location:Users.php');