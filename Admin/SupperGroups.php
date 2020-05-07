<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$suppergroup = new SupperGroup();
$sgds = new SupperGroupDataSource();
$sgds->open();
$suppergroups = $sgds->Fill();
$sgds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->SupperGroups != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>زیر زیرمجموعه ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Supper Groups</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست زیر زیرمجموعه ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertSupperGroup == 1) {
                        ?>
                        <a href="SupperGroup.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن زیر زیرمجموعه جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="alert alert-warning">
                        برای قرارگیری گزینه های موجود در صفحه اصلی در یک سطر ، نباید تعداد آن ها از 6 بیشتر شود.
                    </div>

                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام</th>
                                <th data-hide="phone,tablet">نام لاتین</th>
                                <th> گروه</th>
                                <th data-hide="phone,tablet">زیر گروه</th>
                                <th data-hide="phone,tablet"> تصویر</th>
                                <th data-hide="phone,tablet"> صفحه اصلی</th>
                                <?php
                                if ($role->EditSupperGroup == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteSupperGroup == 1) {
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
                            foreach ($suppergroups as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->SupperGroupId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->LatinName . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Group->Name . " - " . $s->Group->LatinName . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->SubGroup->Name . " - " . $s->SubGroup->LatinName . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src = ../" . $s->Image . " /></div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->PlaceAsMainCat == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($role->EditSupperGroup == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='SupperGroup.php?id=" . $s->SupperGroupId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteSupperGroup == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteConfirm.php?ssgpid=" . $s->SupperGroupId . "'>" . "حذف" . "</a></button></td>";
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
    