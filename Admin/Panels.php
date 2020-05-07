<!DOCTYPE html>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PanelDataSource.inc';
$pds = new PanelDataSource();
$pds->open();
$panels = $pds->Fill();
$pds->close();
?>
<?php
include_once 'Template/top.php';
//if ($role->LinkBoxes != 1) {
//    header('Location:Index.php');
//    die();
//}

include_once 'Template/menu.php';
require_once '../Template/CustomeDate/jdatetime.class.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>درخواست های پنل فروش</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Panel Requests</h2>
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
                                <th> نام</th>
                                <th> ایمیل</th>
                                <th data-hide="phone,tablet"> تاریخ</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <?php
                                if ($role->EditPanel == 1) {
                                    ?>
                                    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($panels as $p) {
                                $date = new jDateTime(true, true, 'Asia/Tehran');
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->PanelId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Email . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $date->date("l j F Y") . "</div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Set Content'><a href='Panel.php?id=" . $p->PanelId . "'>" . "اطلاعات بیشتر" . "</a></div></td>";
                                if ($role->EditPanel == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operatePanel.php?id=" . $p->PanelId . "'>" . "حذف" . "</a></button></td>";
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
    