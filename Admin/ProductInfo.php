<?php
require_once 'Template/top2.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

$p2 = new ProductDataSource();
$p2->open();
$p = $p2->FindOneProductBasedOnId($_POST['productId']);
$p2->close();

$price = new PriceDataSource();
$price->open();
$pprice = $price->GetLastPriceForOneProduct($p->ProductId);
$price->close();
//$menu = new Menu();
$guarantee = new GuaranteeDataSource();
$guarantee->open();
$pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
$guarantee->close();

$pcolor = new ProductColorDataSource();
$pcolor->open();
$ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
$pcolor->close();
//$pmenu = $menu->GetMenusForOneProduct($p->ProductId);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
    <span class="label label-primary">PRODUCT INFO</span>
    <div class="clear-fix"></div>

    <div class="imgdiv"><img src="../<?php echo $p->Image; ?>"/></div>
    <span class="p-id label label-warning" style="font-size: 17px;height: 30px;line-height: 22px"><?php echo $p->ProductId; ?></span>
    <?php
    if ($p->SpecialOffer == 1) {
        echo '<div class="label label-danger" style="float: right; margin-right: 3px;height: 30px;" title="پیشنهاد ویژه">';
        echo '<i class="fa fa-diamond" style="font-size: 17px;line-height: 22px"></i>';
        echo "</div>";
    }
    ?>
    <div class="p-name">
        <?php
        //    if (strlen($p->Name) > 65) {
        //        $str = substr($p->Name, 0, 65) . '...';
        //        echo $str;
        //    } else {
        echo $p->Name;
        //    }
        ?>
    </div>
    <div class="p-latinname">
        <?php
        //    if (strlen($p->LatinName) > 60) {
        //        $str = substr($p->LatinName, 0, 60) . '...';
        //        echo $str;
        //    } else {
        echo $p->LatinName;
        //    }
        ?>
    </div>
    <div class="p-price label-success"
         title="بدون مالیات"><?php echo number_format($pprice) . ' تومان'; ?></div>

</div>
<div class="modal-body">

    <div class="p-cat"><span class="p-span label-success">بازدید</span><span class="p-span-2 label-info">
        <?php
        if ($p->Visits != "") {
            echo $p->Visits;
        } else {
            echo 'هیچ بازدیدی تا حالا نشده!';
        }
        ?>
    </span></div>
    <?php
    if ($p->User->Password != 0) {
        ?>
        <div class="p-cat"><span class="p-span label-success">تخفیف  </span><span
                    class="p-span label-info"><?php echo $p->User->Password . "%"; ?></span></div>
        <?php
    }
    ?>
    <?php
    if ($p->User->UserId != 0) {
        ?>
        <div class="p-cat"><span class="p-span label-success">کپن دریافتی برای خرید  </span><span
                    class="p-span-2 label-info"><?php echo number_format($p->User->UserId) . " کپن"; ?></span></div>
        <?php
    }
    ?>
    <div class="p-cat"><span class="p-span label-success">دسته بندی  </span><span
                class="p-span-2 label-info"><?php echo $p->Group->Name . " (" . $p->Group->LatinName . ")" . " > " . $p->SubGroup->Name . " (" . $p->SubGroup->LatinName . ")" . " > " . $p->SupperGroup->Name . " (" . $p->SupperGroup->LatinName . ")"; ?></span>
    </div>
    <div class="p-quantity"><span class="p-span label-success">تعداد موجودی   </span><span class="p-span-2 label-info"><?php
            $co = 0;
            foreach ($ppcolor as $c) {
                $co += $c->Quantity;
            }
            echo $co . ' عدد';
            ?></span></div>
    <div class="p-quantity"><span class="p-span label-success">تعداد فروخته شده   </span><span class="p-span-2 label-info">
        <?php
        echo $p->Sells . ' عدد';
        ?></span></div>
    <div class="p-colors"><span class="p-span label-success">رنگ ها  </span><?php
        foreach ($ppcolor as $c) {
            echo '<span class="p-span-2 label-info">';
            echo $c->Color->Name;
            echo ' - ';
            echo $c->Quantity . ' عدد';
            echo '</span>';
        }
        ?></span></div>
    <div class="p-guarantee"><span class="p-span label-success">گارانتی ها  </span><?php
        foreach ($pguarantee as $g) {
            echo '<span class="p-span-2 label-info">';
            echo $g->Guarantee->Name . ' - ' . $g->Guarantee->Duration . " : " . number_format($g->Guarantee->Price) . " تومان";
            echo '</span>';
        }
        ?></span></div>
    <div class="p-brand"><span class="p-span label-success">برند محصول  </span><span
                class="p-span-2 label-info"><?php echo $p->Brand->Name . " (" . $p->Brand->LatinName . ")"; ?></div>
    <!--<div class="p-menu"><span class="p-span">منو های مرتبط  </span>--><?php
    //    $i = 0;
    //    foreach ($pmenu as $p3) {
    //        echo '<span class="p-span-2">';
    //        echo $p3->MainMenu->Name . " > " . $p3->SubMenu->SubMenuName . " > " . $p3->SupperMenu->Name;
    //        echo '</span>';
    //        echo '<br/>';
    //        $i++;
    //    }
    //    ?><!--</span></div>-->
    <div class="p-meta-key"><span class="p-span label-success">کلمات کلیدی  </span><?php
        $keywords = explode(",", $p->Keywords);
        foreach ($keywords as $k) {
            echo '<span class="p-span-2 label-info">';
            echo $k;
            echo '</span>';
        }
        ?></div>
    <div class="p-user"><span class="p-span label-success">نویسنده  </span><span
                class="p-span-2 label-info"><?php echo $p->User->Name . " " . $p->Family; ?></span></div>
</div>
<div class="modal-footer">
    <div class="info-buttons">
    <?php
    echo "<a class='btn btn-primary btn-w-m' href='../Post.php?id=$p->ProductId'>" . "بازدید" . "</a>";
    echo "<a class='btn btn-primary btn-w-m' href='Stats.php?id=$p->ProductId'>" . "آمار بازدید محصول" . "</a>";
    if ($role->EditProduct == 1) {
//        echo "<div class='p-btn colors' ><a title='انتخاب رنگ ها' href='ProductColors.php?id=$p->ProductId'>" . "" . "</a></div>";
//        echo "<div class='p-btn guarantee' ><a title='انتخاب گارانتی ها' href='Guarantees.php?id=$p->ProductId'>" . "" . "</a></div>";
//        echo "<div class='p-btn menu' ><a title='انتخاب منو ها' href='Menus.php?id=$p->ProductId'>" . "" . "</a></div>";
//    echo "<div class='p-btn Properties'  title='ویژگی های محصول' ><a href='ProductAndProperties.php?id=" . $p->ProductId . "'>" . "" . "</a></div>";
        echo "<a class='btn btn-success btn-w-m' href='Prices.php?id=" . $p->ProductId . "'>" . "قیمت ها" . "</a>";
        echo "<a class='btn btn-warning btn-w-m' href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a>";
    }
    if ($role->DeleteProduct == 1) {
        echo "<a class='btn btn-danger btn-w-m' onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a>";
    }
    ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
</div>