<!DOCTYPE html>
<?php
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new StatDataSource();
    $p->open();
    $stat = $p->FindOneStatBasedOnId($_GET['id']);
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>آمار</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Statistic</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Stats.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست آمار بازدید ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            آمار بازدید
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <?php
                                if ($cm == "add") {
                                ?>
                                <form action="#" method="post">
                                    <?php
                                    } elseif ($cm == "edit") {
                                    ?>
                                    <form action="UpdateStat.php" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $stat->StatId; ?>"/>
                                        <?php
                                        if (isset($_GET['pid']) == TRUE) {
                                            ?>
                                            <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid'] ?>"/>
                                            <?php
                                        }
                                        }
                                        ?>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                بازدید :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Number" min="0" class="form-control input-sm m-b-xs" id="visit" name="visit" value="<?php
                                                if (isset($stat->Visit) == TRUE) {
                                                    echo $stat->Visit;
                                                }
                                                ?>"/>
                                            </div>
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
