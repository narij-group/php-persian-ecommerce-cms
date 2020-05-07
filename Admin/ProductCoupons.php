<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
$pcds = new ProductCouponDataSource();
$pcds->open();
$productCoupons = $pcds->Fill();
$pcds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->ProductCoupons != 1) {
    header('Location:Index.php');
    die();
}
?>
<?php
include_once 'Template/menu.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>کپن محصولات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product Coupons</h2>
    </div>
</div>
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

<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست کپن محصولات</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="Database">
                        <?php
                        if ($role->InsertProductCoupon == 1) {
                            ?>
                            <a href="ProductCoupon.php">
                                <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                    افزودن کپن محصول
                                </button>
                            </a>
                            <?php
                        }
                        ?>
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> محصول</th>
                                <th> مقدار</th>
                                <th data-hide="phone,tablet"> کاربر</th>
                                <th data-hide="phone,tablet"> تاریخ</th>
                                <?php
                                if ($role->EditProductCoupon == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteProductCoupon == 1) {
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
                            foreach ($productCoupons as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->ProductCouponId . "</div></td>";
                                echo "<td><div class='DatabaseField' ><a class='product-id btn btn-primary btn-rounded' data-toggle='modal' data-target='#productModal'><span class='product-id'>" . $p->Product->ProductId . "</span></a></div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->User->Name . " " . $p->User->Family . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Date . "</div></td>";
                                if ($role->EditProductCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ProductCoupon.php?id=" . $p->ProductCouponId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteProductCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='operateProductCoupon.php?id=" . $p->ProductCouponId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
<!--                            <tfoot style="direction: ltr">-->
<!--                            <tr>-->
<!--                                <td colspan="5">-->
<!--                                    <ul class="pagination pull-right"></ul>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            </tfoot>-->
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
    