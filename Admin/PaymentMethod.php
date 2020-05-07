<!DOCTYPE html>
<?php
$cm = "add";
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PaymentMethodDataSource.inc';
$paymentmethod = new PaymentMethod();
if (isset($_GET['id'])) {
    if ($role->EditPaymentMethod != 1) {
        header('Location:Index.php');
        die();
    }
    $cm = "edit";
    $pmds = new PaymentMethodDataSource();
    $pmds->open();
    $paymentmethod = $pmds->FindOnePaymentMethodBasedOnId($_GET['id']);
    $pmds->close();
} else {
    if ($role->InsertPaymentMethod != 1) {
        header('Location:Index.php');
        die();
    }
}
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>روش پرداخت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Payment Method</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="PaymentMethods.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست روش های پرداخت
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            روش پرداخت
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <?php
                                if ($cm == "add") {
                                ?>
                                <form action="InsertPaymentMethod.php" method="post">
                                    <?php
                                    } elseif ($cm == "edit") {
                                    ?>
                                    <form action="UpdatePaymentMethod.php" method="post">
                                        <input type="hidden" id="id" name="id"
                                               value="<?php echo $paymentmethod->PaymentMethodId; ?>"/>
                                        <?php
                                        }
                                        ?>

                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    نام روش پرداخت :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="Text" class="form-control input-sm m-b-xs" id="name"
                                                           name="name"
                                                           value="<?php
                                                           echo $paymentmethod->Name;
                                                           ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    وضعیت :
                                                </label>
                                                <div class="col-sm-12">
                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($paymentmethod->Activated == 1) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="s-option" name="activated" value="1">
                                                        <label for="s-option">
                                                            فعال
                                                        </label>
                                                    </div>

                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($paymentmethod->Activated == 0) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="f-option" name="activated" value="0">
                                                        <label for="f-option">
                                                            غیرفعال
                                                        </label>
                                                    </div>
                                                    <div class="clear-fix"></div>
                                                </div>
                                            </div>
                                        </fieldset>
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
