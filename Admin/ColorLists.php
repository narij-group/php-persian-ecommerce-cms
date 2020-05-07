<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";

require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ColorListDataSource.inc";


//$colorlist = new ColorList();


$cds = new ColorListDataSource();
$cds->open();
$colorlists = $cds->Fill();
$cds->close();

//$colorlists = $colorlist->Fill();
?>
<?php
include_once 'Template/top.php';
if ($role->Colors != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>رنگ ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Colors</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست رنگ ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertColor == 1) {
                        ?>
                        <a href="ColorList.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن رنگ جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام رنگ</th>
                                <th>رنگ</th>
                                <?php
                                if ($role->EditColor == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteColor == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($colorlists as $c) {
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $c->ColorListId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' ><div class='colorShow' style='background-color : " . $c->Sample . "'>$c->Sample</div></div></td>";
                                if ($role->EditUserCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ColorList.php?id=" . $c->ColorListId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteUserCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteConfirm.php?colorlistid=" . $c->ColorListId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                            <!--                        <tfoot  style="direction: ltr">-->
                            <!--                        <tr>-->
                            <!--                            <td colspan="5">-->
                            <!--                                <ul class="pagination pull-right"></ul>-->
                            <!--                            </td>-->
                            <!--                        </tr>-->
                            <!--                        </tfoot>-->
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    