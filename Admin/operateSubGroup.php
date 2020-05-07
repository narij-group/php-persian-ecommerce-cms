<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {


        $subgroup = new SubGroup();
        $subgroup->SubGroupId = $_POST['id'];
        $subgroup->Group = $_POST['group'];
        $subgroup->Name = $_POST['name'];
        $subgroup->LatinName = $_POST['latinname'];
        $subgroup->Image = $_POST['image'];
        $subgroup->PlaceAsMainCat = $_POST['maincat'];

        $sgds = new SubGroupDataSource();
        $sgds->open();
        $sgds->Update($subgroup);
        $sgds->close();


    } else {

        $subgroup = new SubGroup();
        $subgroup->Group = $_POST['group'];
        $subgroup->Name = $_POST['name'];
        $subgroup->LatinName = $_POST['latinname'];
        $subgroup->Image = $_POST['image'];
        $subgroup->PlaceAsMainCat = $_POST['maincat'];


        $sgds= new SubGroupDataSource();
        $sgds->open();
        $sgds->Insert($subgroup);
        $sgds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteSubGroup != 1) {
        header('Location:Index.php');
        die();
    }
    $subgroup = new SubGroupDataSource();
    $subgroup->open();


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


        $guarantee = new Guarantee();
        $pColor = new ProductColor();
        $pCoupon = new ProductCoupon();
        $menu = new Menu();
        $opinion = new Opinion();
        $comment = new Comment();
        $stat = new Stat();
        $discount = new Discount();
        $pap = new ProductAndProperty();


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
        $product->close();
    }


    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperGroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/RoleDataSource.inc";

    $role = new RoleDataSource();
    $role->open();
    $roles = $role->Fill();

    $suppergroup = new SupperGroupDataSource();
    $suppergroup->open();

    foreach ($roles as $r) {
        $value = str_replace(',' . $_GET['id'], '', $r->AllowedProductGroups);
        $role->CustomUpdate($r, "AllowedProductGroups", $value);
    }


    $temp = $suppergroup->FillBySubgroup($_GET['id']);
    foreach ($temp as $item) {
        foreach ($roles as $r) {
            $value = str_replace(',' . $item->SupperGroupId, '', $r->AllowedProductSupperGroups);
            $role->CustomUpdate($r, "AllowedProductSupperGroups", $value);
        }
        $suppergroup->Delete($item->SupperGroupId);
    }


    $role->close();
    $suppergroup->close();


    $subgroup->Delete($_GET['id']);
    $subgroup->close();

}




header('Location:SubGroups.php');
