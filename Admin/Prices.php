<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

if ($role->Prices != 1) {
    header('Location:Index.php');
    die();
}
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".product-id").click(function () {
            var productId = $(this).text();
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#modal-content").html(result);
                }
            });
        });
    });
</script>
<?php
include_once 'Template/menu.php';
?>
<?php


$product = new Product();
if (isset($_GET['id'])) {

    $pds = new ProductDataSource();
    $pds->open();
    $prices = $pds->GetPrices($_GET['id']);
    $pds->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $pds = new PriceDataSource();
    $pds->open();
    $items = 50;
    $prices = $pds->LimitedFill($items);

    $total = $pds->Fill();
    $pds->close();
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>قیمت ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Prices</h2>
    </div>
</div>

<div class="modalback" id="modalback"></div>
<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست قیمت ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <?php
                    if ($role->InsertPrice == 1) {
                    ?>
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "Price.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن قیمت جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید قیمت جدید اضافه نمایید';
                        }
                        ?></button>
                                </a>

                                <?php
                        }

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

                    <?php
                    if ($role->PriceChange == 1) {
                    ?>
                    <a href="PrePriceIncrease.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-line-chart"></i>
                            تغییر قیمت
                        </button>
                    </a>
                    <?php
                    }
                    ?>

                    <div class="product-info" id="p-info">

                    </div>
                    <div class="modalback">
                        <div class="loader5"><img src="Template/Images/gifs/loading.gif"/></div>
                    </div>
                    <div id="db">
                        <script>
                            $(document).ready(function () {
                                $('#loadmore').click(function () {
                                    $('.modalback').fadeIn(0);
                                    $.ajax({
                                        url: 'LoadMorePrices.php',
                                        type: 'POST',
                                        data: {item: <?php echo $items; ?>},
                                        success: function (result) {
                                            $("#db").html(result);
                                            $('.modalback').fadeOut(0);
                                        },
                                        error: function (result) {
                                            alert("لطفا دوباره امتحان کنید!");
                                            $('.modalback').fadeOut(0);
                                        }
                                    });
                                });
                            });

                        </script>
                        <div class="Database">

                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                   placeholder="جستجو در لیست موجود در این صفحه">
                            <table class="footable table table-stripped" data-page-size="1000000000"
                                   data-filter=#filter>
                                <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th> محصول</th>
                                    <th> قیمت</th>
                                    <th data-hide="phone,tablet"> تاریخ</th>
                                    <th data-hide="phone,tablet"> کاربر</th>
                                    <?php
                                    if ($role->EditPrice == 1) {
                                        ?>
                                        <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                        <?php
                                    }
                                    if ($role->DeletePrice == 1) {
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
                                foreach ($prices as $p) {
                                    $postsCounter++;
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >" . $p->PriceId . "</div></td>";
                                    echo "<td><div class='DatabaseField' ><a class='product-id btn btn-primary btn-rounded' data-toggle='modal' data-target='#productModal' ><span class='product-id'>" . $p->Product . "</span></a></div></td>";
                                    echo "<td><div class='DatabaseField' >" . number_format($p->Value) . ' تومان' . "</div></td>";
                                    echo "<td><div class='DatabaseField' >" . $p->Date . "</div></td>";
                                    echo "<td><div class='DatabaseField' >" . $p->User->Name . " " . $p->User->Family . "</div></td>";
                                    if ($role->EditPrice == 1) {
                                        echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Price.php?";
                                        if (isset($_GET['id']) == TRUE) {
                                            echo "pid=$p->Product&";
                                        }
                                        echo "id=$p->PriceId'>ویرایش</a></button></td>";
                                    }
                                    if ($role->DeletePrice == 1) {
                                        echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operatePrice.php?";
                                        if (isset($_GET['id']) == TRUE) {
                                            echo "pid=$p->Product&";
                                        }
                                        echo "id=$p->PriceId'>حذف</a></button></td>";
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
                            <?php
                            $postsCounter = 0;
                            foreach ($total as $p) {
                                $postsCounter++;
                            }
                            ?>
                        </div>
                        <?php
                        if ($postsCounter > 50) {
                            ?>
                            <input id="loadmore" type="button" name="loadmore" class="load-more2 btn btn-warning btn-w-m"
                                   value="بارگذاری موارد بیشتر..."/>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    