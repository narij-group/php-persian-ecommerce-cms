<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
$purchasebasket = new PurchaseBasketDataSource();
$purchasebasket->open();
$purchasebaskets = $purchasebasket->Fill();
$purchasebasket->close();
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>سبد های خرید</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Purchase Baskets</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>سبد خرید</h5>
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
                            <th>شناسه</th>
                            <th>نام محصول</th>
                            <th>نام مشتری</th>
                            <th data-hide="phone,tablet">قیمت</th>
                            <th data-hide="phone,tablet">تعداد</th>
                            <th data-hide="phone,tablet">تاریخ</th>
                            <!--                <th id="th1"></th>
                                                <th id="th2"></th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($purchasebaskets as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->PurchaseBasketId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Product->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Customer->Name . " " . $p->Customer->Family . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Price . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Count . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Date . "</div></td>";
//                    echo "<td><div class='Edit' ><a href='Cart.php?id=" . $c->CartId . "'>" . "" . "</a></div></td>";
//                    echo "<td><div class='Delete'><a href='DeleteCart.php?id=" . $c->CartId . "'>" . "" . "</a></div></td>";
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
    