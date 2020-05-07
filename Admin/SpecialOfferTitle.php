<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';

$specialoffertitle = new SpecialOfferTitle();
if (isset($_GET['id'])) {
    $stds = new SpecialOfferTitleDataSource();
    $stds->open();
    $specialoffertitle = $stds->FindOneSpecialOfferTitleBasedOnId($_GET['id']);
    $stds->close();
}
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>عنوان پیشنهاد ویژه</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Special Offer Title</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="SpecialOfferTitles.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست عنوان های پیشنهادات ویژه
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            عنوان پیشنهاد ویژه
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="operateSpecialOfferTitle.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $specialoffertitle->SpecialOfferTitleId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                عنوان :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="title"
                                                       name="title"
                                                       value="<?php echo $specialoffertitle->Title; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                وضعیت :
                                            </label>
                                            <div class="col-sm-12">
                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if ($specialoffertitle->Activated == 1) {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="s-option" name="activated" value="1">
                                                    <label for="s-option">
                                                        فعال
                                                    </label>
                                                </div>

                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if ($specialoffertitle->Activated == 0) {
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
                                    <!--                                                <input type="submit" class="Save" value=""/>-->
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
