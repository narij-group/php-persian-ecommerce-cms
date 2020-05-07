<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingMethodDataSource.inc';

//$shippingmethod = new ShippingMethod();
$smds = new ShippingMethodDataSource();
$smds->open();
$shippingmethods = $smds->Fill();

$smds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->ShippingMethods != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>روش های حمل</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Shipping Methods</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست روش های حمل</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertShippingMethod == 1) {
                        ?>

                        <a href="ShippingMethod.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن روش حمل جدید
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
                                <th> روش حمل</th>
                                <th  data-hide="phone,tablet"> تصویر</th>
                                <th> قیمت افزوده به هزینه ارسال</th>
                                <th  data-hide="phone,tablet" data-sort-ignore="true">وضعیت</th>
                                <th  data-hide="phone,tablet" data-sort-ignore="true">مخصوص</th>
                                <?php
                                if ($role->EditShippingMethod == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteShippingMethod == 1) {
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
                            foreach ($shippingmethods as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->ShippingMethodId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src='../" . $s->Image . "' /></div></td>";
                                echo "<td><div class='DatabaseField' >" . number_format($s->Price) . " تومان" . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if (trim($s->AllowedCities) != "") {
                                    echo "<i title='";
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
                                    $city = new CityDataSource();
                                    $city->open();
                                    $city_ids = explode(",", $s->AllowedCities);
                                    foreach ($city_ids as $c) {
                                        if (trim($c) != "") {
                                            echo $city->GetName($c) . ',';
                                        }
                                    }
                                    $city->close();
                                    echo "' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='همگانی' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($role->EditShippingMethod == 1) {
                                    echo "
        <td>
            <button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ShippingMethod.php?id=" . $s->ShippingMethodId . "'>" . "ویرایش" . "</a></button>
        </td>
        ";
                                }
                                if ($role->DeleteShippingMethod == 1) {
                                    echo "
        <td>
            <button class='btn-white btn btn-sm m-xs' title='Delete'><a  onclick='return deleteConfirm()'
                        href='operateShippingMethod.php?id=" . $s->ShippingMethodId . "'>" . "حذف" . "</a></button>
        </td>
        ";
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
    