<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$pds = new ProductDataSource();
$pds->open();
$products = $pds->Fill();
$pds->close();

$productCoupon = new ProductCoupon();
if (isset($_GET['id'])) {
    if ($role->EditProductCoupon != 1) {
        header('Location:Index.php');
        die();
    }
    $pcds = new ProductCouponDataSource();
    $pcds->open();
    $productCoupon = $pcds->FindOneProductCouponBasedOnId($_GET['id']);
    $pcds->close();
} else {
    if ($role->InsertProductCoupon != 1) {
        header('Location:Index.php');
        die();
    }
}
?>
<?php


include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>کپن محصول</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product Coupon</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ProductCoupons.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست کپن محصولات
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            کپن محصول
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateProductCoupon.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $productCoupon->ProductCouponId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                محصول:
                                            </label>
                                            <div class="col-sm-12">
                                                <?php
                                                echo "<select  class='form-control m-b' name='product' id='product' >";
                                                foreach ($products as $p) {
                                                    echo "<option ";
                                                    if (isset($_GET['pid'])) {
                                                        if ($p->ProductId == $_GET['pid']) {
                                                            echo " selected ";
                                                        }
                                                    } elseif (isset($_GET['id'])) {
                                                        if ($p->ProductId == $productCoupon->Product->ProductId) {
                                                            echo " selected ";
                                                        }
                                                    }
                                                    echo "value = '$p->ProductId'>$p->Name</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مقدار :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="value" name="value"
                                                       value="<?php echo $productCoupon->Value; ?>"/></td>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user"
                                           name="user"/>
                                    <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
