<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
if ($role->Discounts != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".product-id").click(function () {
            var productId = $(this).text();
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#modal-content").html(result);
                }
            });
        });
    });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>تخفیف ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Discounts</h2>
    </div>
</div>

<div class="modalback" id="modalback"></div>
<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>
<div class="product-info" id="p-info"></div>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$product = new Product();
if (isset($_GET['id'])) {
//    $product->ProductId = $_GET['id'];
    $pds = new ProductDataSource();
    $pds->open();
    $discounts = $pds->GetDiscount($_GET['id']);
    $pds->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $dds = new DiscountDataSource();
    $dds->open();
    $discounts = $dds->Fill();
    $dds->close();
}
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست تخفیف ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "Discount.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن تخفبف جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید تخفیف جدید اضافه نمایید';
                        }
                        ?></button>
                                </a>
                        <?php


                        if (isset($_GET['id'])) {
                        ?>
                            <a href=" Products.php
                        ">
                        <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-product-hunt"></i>
                            محصولات
                        </button>
                    </a>
                    <?php
                    }
                    ?>

                    <div class="Database">

                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> محصول</th>
                                <th> درصد تخفیف (%)</th>
                                <th data-hide="phone,tablet"> کاربر</th>
                                <?php
                                if ($role->EditDiscount == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteDiscount == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($discounts as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->DiscountId . "</div></td>";
                                echo "<td><div class='DatabaseField' ><a class='product-id btn btn-primary btn-rounded' data-toggle='modal' data-target='#productModal' ><span class='product-id'>" . $p->Product->ProductId . "</span></a></div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->User->Name . " " . $p->User->Family . "</div></td>";
                                if ($role->EditDiscount == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Discount.php?id=" . $p->DiscountId . "''>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteDiscount == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='operateDiscount.php?id=" . $p->DiscountId . "''>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                            <!--                        <tfoot  style="direction: ltr">-->
                            <!--                        <tr>-->
                            <!--                            <td colspan="5">-->
                            <!--                                <ul class="pagination pull-right"></ul>-->
                            <!--                            </td>-->
                            <!--                        </tr>-->
                            <!--                        </tfoot>-->
                        </table>
                    </div>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    