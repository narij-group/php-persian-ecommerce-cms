<!DOCTYPE html>
<?php
include_once 'Template/top.php';
if ($role->PriceChange != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>تغییر قیمت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Price Change</h2>
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

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            تغییر قیمت
                        </div>
                        <div class="panel-body">

                            <div class="alert alert-warning">
                                توجه : برای کاهش قیمت کافی است آن را منفی وارد کنید. ( مثال : -10 )
                            </div>
                            <div class="Inputs">
                                <form action="ChangePrices.php" method="post">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                میزان افزایش :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="number" placeholder='چند درصد...؟' class="form-control input-sm m-b-xs"
                                                       id="value" name="value"/>
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
