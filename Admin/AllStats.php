<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$product = new ProductDataSource();
$stat = new StatDataSource();
if (isset($_GET['id']) && $_GET['id'] != 0) {

    $product->open();
    $stats = $product->GetStats($_GET['id']);
    $product->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $stat->open();
    $stats = $stat->Fill();
    $stat->close();
}
?>
<?php
include_once 'Template/top.php';
?>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>آمار بازدید</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Statistics</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>رنگ بندی</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="Stats.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-bar-chart"></i>
                            نمودار بازدید ها
                        </button>
                    </a>
                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="50"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>صفحه</th>
                                <th>تعداد بازدید</th>
                                <th>IP</th>
                                <th data-hide="phone,tablet">محصول</th>
                                <th data-hide="phone,tablet">زمان</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($stats as $s) {
                                $i++;
                                echo "<tr>";
                                echo "<td class='DatabaseField3' title='$s->Page'><div class='DatabaseField3' >" . $s->Page . "</div></td>";
                                echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Visit . "</div></td>";
                                echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->UserIP . "</div></td>";
                                echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Product . "</div></td>";
                                echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Date . "</div></td>";
                                echo "<td class='DatabaseField2'><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Stat.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$s->Product&";
                                }
                                echo "id=$s->StatId'>ویرایش</a></button></td>";
                                echo "<td class='DatabaseField2'><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='DeleteStat.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$s->Product&";
                                }
                                echo "id=$s->StatId'>حذف</a></button></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                                                    <tfoot  style="direction: ltr">
                                                    <tr>
                                                        <td colspan="5">
                                                            <ul class="pagination pull-right"></ul>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div
<?php
include_once 'Template/bottom.php';
    