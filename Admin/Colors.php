<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorDataSource.inc';
$color = new ColorDataSource();
$color->open();
$colors = $color->Fill();
$color->close();
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>رنگ بندی سایت</h2>
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
                    <h5>لیست کپن ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="alert alert-warning">
                        شدیدا توصیه می شود که رنگ بندی سایت را تغییر ندهید!
                    </div>
                    <div class="Database">

                        <table class="footable table table-stripped" data-page-size="1000000000">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> سبز</th>
                                <th>آبی پر رنگ</th>
                                <th data-hide="phone,tablet">آبی کم رنگ</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "<tr>";
                            echo "<td><div class='DatabaseField' >" . $colors->ColorId . "</div></td>";
                            echo "<td><div class='DatabaseField' >" . $colors->Green . "</div></td>";
                            echo "<td><div class='DatabaseField' >" . $colors->DarkBlue . "</div></td>";
                            echo "<td><div class='DatabaseField' >" . $colors->LightBlue . "</div></td>";
                            echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit' disabled><a href='#'>" . "ویرایش" . "</a></button></td>";
//                            echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Color.php?id=" . $colors->ColorId . "'>" . "ویرایش" . "</a></button></td>";
                            echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='#'>" . "حذف" . "</a></button></td>";
                            echo "</tr>";
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
                    <a href="UpdateColor.php">
                        <button class="btn btn-outline btn-primary btn-w-m" type="button"><i class="fa fa-repeat"></i>
                            بازگشت به حالت پیشفرض
                        </button>
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    