<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';
$colorlist = new ColorList();

if (isset($_GET['id'])) {
    if ($role->EditColor != 1) {
        header('Location:Index.php');
        die();
    }

    $pds = new ColorListDataSource();
    $pds->open();
    $colorlist = $pds->FindOneColorListBasedOnId($_GET['id']);
    $pds->close();

//    $colorlist = $p->FindOneColorList();
} else {
    if ($role->InsertColor != 1) {
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
        <h2>رنگ</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Color</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ColorLists.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست رنگ ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            رنگ
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateColorList.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $colorlist->ColorListId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام رنگ :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $colorlist->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نمونه رنگ :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="color" class="ColorText" id="sample" name="sample"
                                                       value="<?php echo $colorlist->Sample ?>"/>
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
