<!DOCTYPE html>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>انتخاب کنید ...</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>...Select</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Prices.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست قیمت ها
                        </button>
                    </a>

                    <div class="selection">
                        <a class="btn btn-warning" href="PriceIncrease.php">تمام قیمت ها</a>
                        <a class="btn btn-warning" href="PriceIncrease2.php">قیمت های دلخواه</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
