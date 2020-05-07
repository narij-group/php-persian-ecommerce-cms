<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';
$guarantee = new Guarantee();
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new GuaranteeDataSource();
    $p->open();
    $guarantee = $p->FindOneGuaranteeBasedOnId($_GET['id']);
    $p->close();
}
$guaranteelist = new GuaranteeListDataSource();
$guaranteelist->open();
$glist = $guaranteelist->Fill();
$guaranteelist->close();
?>
<?php
include_once 'Template/top.php';
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#group").select2({
            placeholder: "انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>

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

                    <a href="Guarantees.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
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
                                <?php
                                if ($cm == "add") {
                                ?>
                                <form action="InsertGuarantee.php" method="post">
                                    <?php
                                    } elseif ($cm == "edit") {
                                    ?>
                                    <form action="UpdateGuarantee.php" method="post">
                                        <input type="hidden" id="id" name="id"
                                               value="<?php echo $guarantee->GuaranteeId; ?>"/>
                                        <?php
                                        if (isset($_GET['pid']) == TRUE) {
                                            ?>
                                            <input type="hidden" id="pid" name="pid"
                                                   value="<?php echo $_GET['pid'] ?>"/>
                                            <?php
                                        }
                                        }
                                        ?>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    گارانتی :
                                                </label>
                                                <div class="col-sm-12">
                                                    <select required="" id="group" name="group" class='form-control m-b' style="width: ">
                                                        <option></option>
                                                        <?php
                                                        foreach ($glist as $g) {
                                                            echo '<option ';
                                                            if ($g->GuaranteeListId == $guarantee->Guarantee->GuaranteeListId) {
                                                                echo ' selected ';
                                                            }
                                                            echo ' value=' . $g->GuaranteeListId . '>';
                                                            echo $g->Name;
                                                            echo '</option>';
                                                        }
                                                        ?>
                                                    </select>
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
