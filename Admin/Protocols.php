<!DOCTYPE html>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

if (isset($_GET['id'])) {

    $product = new ProductDataSource();
    $product->open();
    $protocols = $product->GetProtocols($_GET['id']);
    $product->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $protocol = new ProtocolDataSource();
    $protocol->open();
    $protocols = $protocol->Fill();
    $protocol->close();
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پروتکل ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Protocols</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>پروتکل</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "Protocol.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن پروتکل جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید پروتکل جدید اضافه نمایید';
                        }
                        ?></button>
                                </a>

                                <?php

                        if (isset($_GET['id'])) {
                        ?>
                                    <a href=" Products.php
                        ">
                        <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-product-hunt"></i>
                            محصولات
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
                                <th> نام</th>
                                <th> تصویر</th>
                                <th data-hide="phone,tablet"> محصول</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($protocols as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->ProtocolId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->ProtocolList->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src=../" . $p->ProtocolList->Image . " /></div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Product . "</div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Protocol.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$p->Product&";
                                }
                                echo "id=$p->ProtocolId'>ویرایش</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateProtocol.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$p->Product&";
                                }
                                echo "id=$p->ProtocolId'>حذف</a></button></td>";
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
    