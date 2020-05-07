<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';
$linkboxtitle = new LinkboxTitle();

if (isset($_GET['id'])) {
    $p = new LinkboxTitleDataSource();
    $p->open();
    $linkboxtitle = $p->FindOneLinkboxTitleBasedOnId($_GET['id']);
    $p->close();
}

?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>زیر گروه پیوند</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>inkbox Title</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="LinkboxTitles.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست زیر گروه ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            زیر گروه
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateLinkBoxTitle.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $linkboxtitle->LinkboxTitleId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیرگروه :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $linkboxtitle->Name; ?>"/>
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
