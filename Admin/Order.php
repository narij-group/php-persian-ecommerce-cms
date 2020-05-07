<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OrderDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';

$order = new Order();
if (isset($_GET['id'])) {
    $ods = new OrderDataSource();
    $ods->open();
    $order = $ods->FindOneOrderBasedOnId($_GET['id']);
    $ods->close();

    $province = new City();
    $cds = new CityDataSource();
    $cds->open();
    $city = $cds->GetName($order->Customer->City);
    $cds->close();

    $supperGroup = new SupperGroup();
    $spds = new SupperGroupDataSource();
    $spds->open();
    $supperGroup = $spds->FindOneSupperGroupBasedOnId($order->SupperGroup->SupperGroupId);
    $spds->close();


}
?>
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>درخواست</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Order</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Orders.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست سفارشات
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            سفارش
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateOrder.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $order->OrderId; ?>"/>
                                    <input type="hidden" id="date" name="date"
                                           value="<?php echo $order->Date; ?>"/>
                                    <input type="hidden" id="customer" name="customer"
                                           value="<?php echo $order->Customer->CustomerId; ?>"/>

                                    <?php
                                    if ($role->EditOrder == 1) {
                                    ?>
                                    <fieldset class="form-horizontal">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                وضعیت :
                                            </label>
                                            <div class="col-sm-12">
                                                <select id="status" name="status" class="form-control m-b">
                                                    <?php
                                                    if ($order->Status == 0) {
                                                        echo '<option selected value="0">بررسی نشده</option>';
                                                        echo '<option value="1">بررسی شده</option>';
                                                    } elseif ($order->Status == 1) {
                                                        echo '<option value="0">بررسی نشده</option>';
                                                        echo '<option selected value="1">بررسی شده</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                پاسخ :
                                            </label>
                                            <div class="col-sm-12">
                                                <textarea id="replay" name="replay"
                                                          class="form-control input-sm m-b-xs"><?php echo $order->Replay ?></textarea>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام مشتری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $order->Customer->Name . " " . $order->Customer->Family; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                ایمیل مشتری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $order->Customer->Email ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                شهر مشتری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $city ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                آدرس مشتری :
                                            </label>
                                            <div class="col-sm-12">
                                                <textarea readonly
                                                          class="form-control input-sm m-b-xs"><?php echo $order->Customer->Address ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مجموعه :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $supperGroup->Group->Name ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیر مجموعه :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $supperGroup->SubGroup->Name ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیرزیر مجموعه :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="hidden" id="suppergroup" name="suppergroup"
                                                       value="<?php echo $order->SupperGroup->SupperGroupId; ?>"/>
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $order->SupperGroup->Name ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                متن :
                                            </label>
                                            <div class="col-sm-12">
                                                <textarea readonly name="content" id="content"
                                                          class="form-control input-sm m-b-xs"><?php echo $order->Content ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                فایل :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="hidden" id="file" name="file"
                                                       value="<?php echo $order->File; ?>"/>
                                                <?php
                                                if ($order->File != "") {
                                                    ?>
                                                    <a href="<?php echo "../" . $order->File; ?>" download>
                                                        <button class="btn btn-success btn-w-m" type="button"><i
                                                                    class="fa fa-download"></i>
                                                            دریافت
                                                        </button>
                                                    </a>
                                                    <?php
                                                } else {
                                                    echo "<i title='ندارد' class='fa fa-remove text-danger'></i><span style='margin-right: 10px;;font-size: 15px;font-weight: bold'>ندارد</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>


                                    </fieldset>
                                    <?php
                                    if ($role->EditOrder == 1) {
                                        ?>
                                        <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                    class="fa fa-check"></i><strong>تایید</strong></button>
                                        <?php
                                    }
                                    ?>
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
