<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PanelDataSource.inc';

$panel = new Panel();
if (isset($_GET['id'])) {
    $pds = new PanelDataSource();
    $pds->open();
    $panel = $pds->FindOnePanelBasedOnId($_GET['id']);
    $pds->close();
}
?>
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>درخواست پنل فروش</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Panel</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Panels.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست درخواست ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            درخواست
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form>
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $order->OrderId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام و نام خانوادگی :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $panel->Name ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                ایمیل :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $panel->Email ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                موبایل :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" readonly
                                                       value="<?php echo $panel->Mobile ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                متن :
                                            </label>
                                            <div class="col-sm-12">
                                                <textarea readonly
                                                          class="form-control input-sm m-b-xs"><?php echo $panel->Content ?></textarea>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <a href="Panels.php">
                                        <button class="btn btn-primary btn-w-m pull-right" type="button"><i
                                                    class="fa fa-share"></i>
                                            <strong>بازگشت</strong>
                                        </button>
                                    </a>
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
