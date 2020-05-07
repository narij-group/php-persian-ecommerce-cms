<!DOCTYPE html>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OrderDataSource.inc';
$ods = new OrderDataSource();
$ods->open();
$orders = $ods->Fill();
$ods->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Orders != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
require_once '../Template/CustomeDate/jdatetime.class.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>درخواست های کالا</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Orders</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست درخواست ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="Database">

                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> نام مشتری</th>
                                <th> زیرزیرگروه</th>
                                <th data-hide="phone,tablet"> تاریخ</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"> فایل</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"> وضعیت</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <?php
                                if ($role->EditOrder == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($orders as $o) {
                                $date2 = explode('/', $o->Date);
                                $date = new jDateTime(true, true, 'Asia/Tehran');
                                $time2 = $date->mktime(0, 0, 0, intval($date2[1]), intval($date2[2]), intval($date2[0]), false, 'America/New_York');
                                $date = new jDateTime("l j F Y", $o->Date, true, true, 'Asia/Tehran');
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $o->OrderId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $o->Customer->Name . " " . $o->Customer->Family . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $o->SupperGroup->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $date->date("l j F Y", $time2, true, true, 'Asia/Tehran') . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($o->File != "") {
                                    echo "<i title='دارد' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='ندارد' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($o->Status == 0) {
                                    echo "<td><div class='DatabaseField' style='color: #f07582' >بررسی نشده</div></td>";
                                } else {
                                    echo "<td><div class='DatabaseField' style='color: #1ab394'>بررسی شده</div></td>";
                                }
                                if ($role->EditOrder == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateOrder.php?id=" . $o->OrderId . "'>" . "حذف" . "</a></button></td>";
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Set Content'><a href='Order.php?id=" . $o->OrderId . "'>" . "نمایش و پاسخ" . "</a></div></td>";
                                }else{
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Set Content'><a href='Order.php?id=" . $o->OrderId . "'>" . "نمایش" . "</a></div></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                            <!--                            <tfoot style="direction: ltr">-->
                            <!--                            <tr>-->
                            <!--                                <td colspan="5">-->
                            <!--                                    <ul class="pagination pull-right"></ul>-->
                            <!--                                </td>-->
                            <!--                            </tr>-->
                            <!--                            </tfoot>-->
                        </table>
                    </div>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once 'Template/bottom.php';
    