<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$price = new Price();
if (isset($_GET['id'])) {
    if ($role->EditPrice != 1) {
        header('Location:Index.php');
        die();
    }
    $pds = new PriceDataSource();
    $pds->open();
    $price = $pds->FindOnePriceBasedOnId($_GET['id']);
    $pds->close();
} else {
    if ($role->InsertPrice != 1) {
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
        <h2>قیمت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Price</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Prices.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست قیمت ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            قیمت
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="UpdatePrice.php" method="post">
                                    <input type="hidden" id="id" name="id" value="<?php echo $price->PriceId; ?>"/>
                                    <?php
                                    if (isset($_GET['pid']) == TRUE) {
                                        ?>
                                        <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid'] ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                قیمت :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" placeholder='قیمت را به تومان وارد کنید...'
                                                       onkeypress="return CheckNumeric();"
                                                       onkeyup="FormatCurrency(this);"
                                                       class="form-control input-sm m-b-xs" id="value" name="value"
                                                       value="<?php if (isset($price->Value) == TRUE) {
                                                           echo number_format($price->Value);
                                                       } ?>"/>
                                            </div>
                                            <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user"
                                                   name="user"/>
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
