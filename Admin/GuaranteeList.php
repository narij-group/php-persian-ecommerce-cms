<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';

$guaranteelist = new GuaranteeList();
if (isset($_GET['id'])) {
    if ($role->EditGuarantee != 1) {
        header('Location:Index.php');
        die();
    }
    $glds = new GuaranteeListDataSource();
    $glds->open();
    $guaranteelist = $glds->FindOneGuaranteeListBasedOnId($_GET['id']);
    $glds->close();

} else {
    if ($role->InsertGuarantee != 1) {
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
        <h2>گارانتی</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Guarantee</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="GuaranteeLists.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست گارانتی ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            گارانتی
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateGuaranteeList.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $guaranteelist->GuaranteeListId; ?>"/>
                                    <?php
                                    if (isset($_GET['pid']) == TRUE) {
                                        ?>
                                        <input type="hidden" id="pid" name="pid"
                                               value="<?php echo $_GET['pid'] ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام گارانتی :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php
                                                       echo $guaranteelist->Name;
                                                       ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مدت زمان :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="duration" name="duration"
                                                       placeholder=" مثال : 24 ماه یا 1 سال" value="<?php
                                                echo $guaranteelist->Duration;
                                                ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                قیمت :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" onkeypress="return CheckNumeric();"
                                                       onkeyup="FormatCurrency(this);"
                                                       class="form-control input-sm m-b-xs" placeholder="قیمت به تومان" id="price"
                                                       name="price"
                                                       value="<?php
                                                       echo number_format($guaranteelist->Price);
                                                       ?>"/>
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
