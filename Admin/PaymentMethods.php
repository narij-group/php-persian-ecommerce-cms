<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PaymentMethodDataSource.inc';
//$paymentmethod = new PaymentMethod();

$pmds = new PaymentMethodDataSource();
$pmds->open();

$paymentmethods = $pmds->Fill();

$pmds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->PaymentMethods != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>روش های پرداخت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Payment Methods</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست روش های پرداخت</h5>
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
                                <!--                    <th>شناسه </th>-->
                                <th> روش پرداخت</th>
                                <th data-sort-ignore="true">وضعیت</th>
                                <?php
                                if ($role->EditPaymentMethod == 1) {
                                    ?>
                                    <th id="th1" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($paymentmethods as $s) {
                                $postsCounter++;
                                echo "<tr>";
//                    echo "<td><div class='DatabaseField' >" . $s->PaymentMethodId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($role->EditPaymentMethod == 1) {
                                    echo "<td><a class='btn btn-success btn-circle' href='SwitchPaymentMethod.php?id=" . $s->PaymentMethodId . "'>" . "<i title='غیرفعال' class='fa fa-exchange' style='padding-right: 5px'></i>" . "</a></td>";
//                    echo "<td><div class='Edit' ><a href='PaymentMethod.php?id=" . $s->PaymentMethodId . "'>" . "" . "</a></div></td>";
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
    