<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
$province = new Province();
$shipping = new Shipping();


$sds = new ShippingDataSource();
$sds->open();
$shippings = $sds->Fill();
$sds->close();


?>
<?php
include_once 'Template/top.php';
if ($role->Shippings != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>حمل و نقل ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Shippings</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست حمل و نقل ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertShipping == 1) {
                        ?>

                        <a href="Shipping.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن حمل و نقل جدید
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
                                <th> استان</th>
                                <th>هزینه ارسال</th>
                                <?php
                                if ($role->EditShipping == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteShipping == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </tr>
                            </thead>
                            <?php

                            $pds = new ProvinceDataSource();
                            $pds->open();


                            $postsCounter = 0;
                            foreach ($shippings as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->ShippingId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $pds->GetName($s->City) . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . number_format($s->Price) . " تومان </div></td>";
                                if ($role->EditShipping == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Shipping.php?id=" . $s->ShippingId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteShipping == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='operateShipping.php?id=" . $s->ShippingId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }


                            $pds->close();

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
    