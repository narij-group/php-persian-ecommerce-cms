<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

$sds = new ServiceDataSource();
$sds->open();
$services = $sds->Fill();
$sds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Services != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>خدمات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Services</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست خدمات</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertService == 1) {
                        ?>
                        <a href="Service.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن خدمت جدید
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
                                <th> نام سرویس</th>
                                <th> هزینه</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true">وضعیت</th>
                                <?php
                                if ($role->EditService == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteService == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($services as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->ServiceId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . number_format($s->Price) . " تومان" . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->Activated == 1) {
                                    echo "<img title='فعال' src = 'Template/Images/checked.png' />";
                                } else {
                                    echo "<img title='غیرفعال' src = 'Template/Images/not-checked.png' />";
                                }
                                echo "</div></td>";
                                if ($role->EditService == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Service.php?id=" . $s->ServiceId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteService == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a  onclick='return deleteConfirm()' href='operateService.php?id=" . $s->ServiceId . "'>" . "حذف" . "</a></button></td>";
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
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    