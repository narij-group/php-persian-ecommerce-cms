<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$customer = new Customer();

if (isset($_GET['id'])) {
    if ($role->EditCustomer != 1) {
        header('Location:Index.php');
        die();
    }
    $cds = new CustomerDataSource();
    $cds->open();
    $customer = $cds->FindOneCustomerBasedOnId($_GET['id']);
    $cds->close();
} else {
    if ($role->InsertCustomer != 1) {
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
        <h2>مشتری</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Customer</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Customers.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست مشتری ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            مشتری
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateCustomer.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $customer->CustomerId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $customer->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام خانوادگی :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="family" name="family"
                                                       value="<?php echo $customer->Family; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام کاربری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="username" name="username"
                                                       value="<?php echo $customer->Username; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                رمز عبور :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control input-sm m-b-xs" id="password"
                                                       name="password"
                                                       value="<?php echo $customer->Password; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                پست الکترونیک :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="email" name="email"
                                                       value="<?php echo $customer->Email; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                استان :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="estate" name="estate"
                                                       value="<?php echo $customer->Estate; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                شهر :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="city" name="city"
                                                       value="<?php echo $customer->City; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                کد ملی :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="nationalitycode"
                                                       name="nationalitycode"
                                                       value="<?php echo $customer->NationalityCode; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                آدرس :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="address" name="address"
                                                       value="<?php echo $customer->Address; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                تلفن همراه:
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="address" name="mobile"
                                                       value="<?php echo $customer->Mobile; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                تلفن ثابت:
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="address" name="phone"
                                                       value="<?php echo $customer->Phone; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                کد پستی:
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="address" name="postcode"
                                                       value="<?php echo $customer->PostCode; ?>"/>
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
