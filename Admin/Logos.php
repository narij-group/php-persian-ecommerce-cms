<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';


$lds = new LogoDataSource();
$lds->open();
$logos = $lds->Fill();
$lds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Brands != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>برند ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Brands</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست برند ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertBrand == 1) {
                        ?>
                        <a href="Logo.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن برند جدید
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
                                <th>نام</th>
                                <th>نام لاتین</th>
                                <th data-hide="phone,tablet"> تصویر</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"> نمایش</th>
                                <?php
                                if ($role->EditBrand == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteBrand == 1) {
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
                            foreach ($logos as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->LogoId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->LatinName . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src='../" . $s->Image . "' /></div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->Activated == 1) {
                                    echo "<i title='نمایش در صفحه اصلی' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='عدم نمایش' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($role->EditBrand == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Logo.php?id=" . $s->LogoId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteBrand == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateLogo.php?id=" . $s->LogoId . "'>" . "حذف" . "</a></button></td>";
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
    