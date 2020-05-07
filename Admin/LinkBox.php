<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';

$ltds = new LinkboxTitleDataSource();
$ltds->open();
$linkboxtitles = $ltds->Fill();
$ltds->close();

$linkbox = new LinkBox();
if (isset($_GET['id'])) {
    $lds = new LinkBoxDataSource();
    $lds->open();
    $linkbox = $lds->FindOneLinkBoxBasedOnId($_GET['id']);
    $lds->close();
}
?>
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پیوند</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Link Box</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="LinkBoxes.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست پیوند ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            پیوند
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning">
                                توجه : اگر میخواهید برای لینک ها متن مجزا بنویسید، "لینک صفحه" را خالی بگذارید!
                            </div>
                            <div class="Inputs">
                                <form action="operateLinkBox.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $linkbox->LinkBoxId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $linkbox->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیر گروه :
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control m-b" id="linkboxtitle" name="linkboxtitle">
                                                    <?php
                                                    foreach ($linkboxtitles as $lbt) {
                                                        echo "<option value='$lbt->LinkboxTitleId' ";
                                                        if ($linkbox->LinkboxTitle->LinkboxTitleId == $lbt->LinkboxTitleId) {
                                                            echo ' selected ';
                                                        }
                                                        echo " >";
                                                        echo $lbt->Name;
                                                        echo '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                لینک صفحه:
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="link" name="link"
                                                       value="<?php echo $linkbox->Link; ?>"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user"
                                           name="user"/>
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
