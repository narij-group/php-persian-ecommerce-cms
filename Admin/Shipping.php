<!DOCTYPE html>
<?php
include_once 'Template/top.php';
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
$Shipping = new Shipping();
if (isset($_GET['id'])) {
    if ($role->EditShipping != 1) {
        header('Location:Index.php');
        die();
    }

    $cm = "edit";
    $sds = new ShippingDataSource();
    $sds->open();
    $Shipping = $sds->FindOneShippingBasedOnId($_GET['id']);
    $sds->close();
} else {
    if ($role->InsertShipping != 1) {
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
        <h2>حمل و نقل</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Shipping</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="shippings.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست حمل و نقل ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            حمل و نقل
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <?php
                                //---------------------------------------------ADD-----------------------------------------------------//
                                if ($cm == "add") {
                                ?>
                                <form action="InsertShipping.php" method="post">
                                    <input type="hidden" class="form-control input-sm m-b-xs" id="product"
                                           name="product"
                                           value="<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>"/>
                                    <div class="alert alert-warning">
                                        توجه : اگر هزینه ارسال به استانی رایگان است، قیمت آن را خالی بگذارید.
                                    </div>
                                    <div class="alert alert-warning">
                                        توجه : هزینه ارسال به هر استان را به تومان وارد کنید.
                                    </div>
                                    <fieldset class="form-horizontal">
                                        <?php
                                        $n = 0;
                                        //                $Province = new Province();

                                        $pds = new ProvinceDataSource();
                                        $pds->open();
                                        $provinces = $pds->Fill();
                                        $pds->close();

                                        foreach ($provinces as $p2) {
                                            echo '<div class="form-group">';
                                            echo "<label class='col-sm-12 control-label'>" . $p2->Name . " ( هزینه ارسال ) " . " : </label>";
                                            echo "<input type='hidden' value='$p2->ProvinceId' name='fieldname$n' id = 'fieldname$n' />";
                                            echo '<div class="col-sm-12">';
                                            echo "<input type='text' placeholder='قیمت را به تومان وارد کنید...' onkeypress='return CheckNumeric();' onkeyup='FormatCurrency(this);'  class='form-control input-sm m-b-xs' name='fieldvalue$n' id = 'fieldvalue$n' />";
                                            echo '</div>';
                                            echo '</div>';
                                            $n++;
                                        }
                                        echo '</fieldset>';
                                        if ($cm == "add") {
                                        ?>
                                        <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                    class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>
                                <?php
                                }
                                }
                                //---------------------------------------------Edit-----------------------------------------------------//
                                if ($cm == "edit") {
                                ?>
                                <form action="UpdateShipping.php" method="post">
                                    <input type="hidden" id="id" name="id" value="<?php echo $p->ShippingId; ?>"/>
                                    <input type="hidden" class="form-control input-sm m-b-xs" id="product" name="product"
                                           value="<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>"/>
                                    <div class="alert alert-warning">
                                        توجه : هزینه ارسال به هر استان را به تومان وارد
                                    </div>
                                    <fieldset class="form-horizontal">
                                        <?php
                                        //                    $Province = new Province();

                                        echo '<div class="form-group">';
                                        $pds = new ProvinceDataSource();
                                        $pds->open();
                                        echo "<label class='col-sm-12 control-label'>" . $pds->GetName($Shipping->City) . " ( هزینه ارسال )" . " : </label>";
                                        $pds->close();
                                        echo "<input type='hidden' value='$Shipping->ShippingId' name='id' id = 'id' />";
                                        echo '<div class="col-sm-12">';
                                        echo "<input type='text' placeholder='قیمت را به تومان وارد کنید...' class='form-control input-sm m-b-xs' name='price'  onkeypress='return CheckNumeric();' onkeyup='FormatCurrency(this);' value='" . number_format($Shipping->Price) . "' id = 'price' />";
                                        echo '</div>';
                                        echo '</div>';
                                        }
                                        echo '</fieldset>';
                                        if ($cm == "edit") {
                                        ?>
                                        <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                    class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>
                                <?php
                                }
                                ?>
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
