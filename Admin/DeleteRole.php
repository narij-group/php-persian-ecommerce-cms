<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteRole != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RoleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';


$user = new UserDataSource();
$user->open();
$users = $user->GetThisRoleUsers($_GET["id"]);
$user->close();


foreach ($users as $user) {

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
    $d = new DiscountDataSource();
    $d->open();
    $temp = $d->GetThisUserDiscounts($user->UserId);
    foreach ($temp as $t) {
        $d->Delete($t->DiscountId);
    }
    $d->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
    $o = new PriceDataSource();
    $o->open();
    $temp = $o->GetThisUserPrices($user->UserId);
    foreach ($temp as $t) {
        $o->Delete($t->PriceId);
    }
    $o->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
    $n = new NewsDataSource();
    $n->open();
    $temp = $n->GetThisUserNews($user->UserId);
    foreach ($temp as $t) {
        $n->Delete($t->NewsId);
    }
    $n->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
    $fp = new ProductDataSource();
    $fp->open();
    $temp = $fp->GetThisUserProducts($user->UserId);
    $fp->close();

    foreach ($temp as $item) {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';

        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';

        $pCoupon = new ProductCoupon();


        $pds = new ProductDataSource();
        $pds->open();
//        $product->ProductId = $item->ProductId;
        $pds->DeleteFolder("../Images/$item->ProductId");


        $price = new PriceDataSource();
        $price->open();
        $prices = $price->GetPricesForOneProduct($item->ProductId);
        foreach ($prices as $p) {
            $price->Delete($p->PriceId);
        }
        $price->close();


        $guarantee = new GuaranteeDataSource();
        $guarantee->open();

        $guarantees = $guarantee->GetGuaranteesForOneProduct($item->ProductId);
        foreach ($guarantees as $g) {
            $guarantee->Delete($g->GuaranteeId);
        }
        $guarantee->close();


        $pColor = new ProductColorDataSource();
        $pColor->open();
        $pColors = $pColor->GetProductColorsForOneProduct($item->ProductId);
        foreach ($pColors as $pc) {
            $pColor->Delete($pc->ProductColorId);
        }
        $pColor->close();
//$pCoupons = $pCoupon->FindOneProductCoupons($product->ProductId);
//foreach ($pCoupons as $pcc) {
//    $pcc->Delete();
//}
        $stat = new StatDataSource();
        $stat->open();
        $stats = $stat->GetStatsForOneProduct($item->ProductId);
        foreach ($stats as $s) {
            $stat->Delete($s->StatId);
        }
        $stat->close();

        $menu = new MenuDataSource();
        $menu->open();
        $menus = $menu->GetMenusForOneProduct($item->ProductId);
        foreach ($menus as $m) {
            $menu->Delete($m->MenuId);
        }
        $menu->close();


        $opinion = new OpinionDataSource();
        $opinion->open();
        $opinions = $opinion->GetOpinionsForProduct($item->ProductId);
        foreach ($opinions as $o) {
            $opinion->Delete($o->OpinionId);
        }
        $opinion->close();


        $comment = new CommentDataSource();
        $comment->open();
        $comments = $comment->GetCommentsForProduct($item->ProductId);
        foreach ($comments as $c) {
            $comment->Delete($c->CommentId);
        }
        $comment->close();


        $discount = new DiscountDataSource();
        $discount->open();
        $discounts = $discount->GetDiscountsForOneProduct($item->ProductId);
        foreach ($discounts as $d) {
            $discount->Delete($d->DiscountId);
        }
        $discount->close();


        $pap = new ProductAndPropertyDataSource();
        $pap->open();
        $paps = $pap->GetPropertiesForOneProduct($item->ProductId);
        foreach ($paps as $p) {
            $pap->Delete($p->ProductAndPropertyId);
        }
        $pap->close();

        $pds->Delete($item->ProductId);
        $pds->close();
    }

    $uds = new UserDataSource();
    $uds->open();
    $uds->Delete($user->UserId);
    $uds->close();

}

$role = new RoleDataSource();
$role->open();
$role->Delete($_GET["id"]);
$role->close();
header('Location:Roles.php');
