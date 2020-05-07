<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
$userCoupon = new UserCoupon();
if (isset($_GET['id'])) {
    if ($role->EditUserCoupon != 1) {
        header('Location:Index.php');
        die();
    }
    $u = new UserCouponDataSource();
    $u->open();
    $userCoupon = $u->FindOneUserCouponBasedOnId($_GET['id']);
    $u->close();
} else {
    if ($role->InsertUserCoupon != 1) {
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
        <h2>کپن مشتری</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>User Coupon</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="UserCoupons.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست کپن ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            کپن مشتری
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="operateUserCoupon.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $userCoupon->UserCouponId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                کد ملی مشتری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm m-b-xs" id="customer" name="customer"
                                                       value="<?php echo $userCoupon->Customer->NationalityCode; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مقدار :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="value" name="value"
                                                       value="<?php echo $userCoupon->Value; ?>"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!--                                        <input type="submit" class="Save" value=""/>-->
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
