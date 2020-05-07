<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $gds = new GroupDataSource();
        $gds->open();
        $group = new Group();
        $group->GroupId = $_POST['id'];
        $group->Name = $_POST['name'];
        $group->LatinName = $_POST['latinname'];
        $group->Image = $_POST['image'];
        $group->PlaceAsMainCat = $_POST['maincat'];
        $gds->Update($group);
        $gds->close();

    } else {

        $gds = new GroupDataSource();
        $gds->open();
        $group = new Group();
        $group->Name = $_POST['name'];
        $group->LatinName = $_POST['latinname'];
        $group->Image = $_POST['image'];
        $group->PlaceAsMainCat = $_POST['maincat'];
        $gds->Insert($group);
        $gds->close();

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteGroup != 1) {
        header('Location:Index.php');
        die();
    }
    $group = new GroupDataSource();
    $group->open();
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
    $product = new ProductDataSource();
    $product->open();
    $temp = $product->FillBySGroup($_GET['id']);
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

        $product->ProductId = $_GET['id'];
        $product->DeleteFolder("../Images/$item->ProductId");


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


        $pCoupon = new ProductCoupon();
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

        $product->Delete($item->ProductId);
    }
    $product->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubGroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperGroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/RoleDataSource.inc";


    $subgroup = new SubGroupDataSource();
    $subgroup->open();
    $temp = $subgroup->FillByGroup($_GET['id']);


    $role = new RoleDataSource();
    $role->open();
    $roles = $role->Fill();

    $suppergroup = new SupperGroupDataSource();
    $suppergroup->open();


    foreach ($roles as $r) {
        $value = str_replace(',' . $_GET['id'], '', $r->AllowedProductGroups);
        $role->CustomUpdate($r, "AllowedProductGroups", $value);
    }

    $role->close();

    foreach ($temp as $item) {
        $temp2 = $suppergroup->FillBySubgroup($item->SubGroupId);
        foreach ($temp2 as $item2) {

            foreach ($roles as $r) {
                $value = str_replace(',' . $item->SupperGroupId, '', $r->AllowedProductSupperGroups);
                $role->CustomUpdate($r, "AllowedProductSupperGroups", $value);
            }

            foreach ($roles as $r) {
                $value = str_replace(',' . $item->SubGroup, '', $r->AllowedProductSubGroups);
                $role->CustomUpdate($r, "AllowedProductSubGroups", $value);
            }

            $suppergroup->Delete($item2->SupperGroupId);
        }
        $subgroup->Delete($item->SubGroupId);
    }

    $role->close();
    $suppergroup->close();
    $subgroup->close();

    $group->Delete($_GET['id']);
    $group->close();


}

header('Location:Groups.php');



