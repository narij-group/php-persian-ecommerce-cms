<!DOCTYPE html>
<?php
include_once 'Template/top.php';
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

$service = new Service();
if (isset($_GET['id'])) {
    if ($role->EditService != 1) {
        header('Location:Index.php');
        die();
    }

    $cm = "edit";
    $sds = new ServiceDataSource();
    $sds->open();
//    $p = new Service();
//    $p->ServiceId = $_GET['id'];
    $service = $sds->FindOneServiceBasedOnId($_GET['id']);
    $sds->close();
} else {
    if ($role->InsertService != 1) {
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
        <h2>خدمت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Service</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Services.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست خدمات
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            خدمت
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateService.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $service->ServiceId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام سرویس :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php
                                                       echo $service->Name;
                                                       ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                هزینه :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" onkeypress="return CheckNumeric();"
                                                       onkeyup="FormatCurrency(this);"
                                                       class="form-control input-sm m-b-xs" id="price"
                                                       placeholder="قیمت را به تومان وارد کنید..."
                                                       name="price" value="<?php
                                                echo number_format($service->Price);
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
                                                    if ($service->Activated == 1) {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="s-option" name="activated" value="1">
                                                    <label for="s-option">
                                                        فعال
                                                    </label>
                                                </div>

                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if ($service->Activated == 0) {
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
