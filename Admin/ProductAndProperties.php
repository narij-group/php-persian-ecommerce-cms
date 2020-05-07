<!DOCTYPE html>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';


if (isset($_GET['id'])) {
    $product = new ProductDataSource();
    $product->open();
    $productAndProperties = $product->GetProperties($_GET['id']);
    $product->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $productAndProperty = new ProductAndPropertyDataSource();
    $productAndProperty->open();
    $productAndProperties = $productAndProperty->Fill();
    $productAndProperty->close();
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

<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="modalback" id="modalback"></div>
<div class="product-info" id="p-info"></div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>ویژگی ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Properties</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>رنگ بندی</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "ProductAndProperty.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن ویژگی جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید ویژگی جدید اضافه نمایید';
                        }
                        ?></button></a>

                    <div class=" Database
                        ">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> محصول</th>
                                <th> ویژگی</th>
                                <th data-hide="phone,tablet">محتوا</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($productAndProperties as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->ProductAndPropertyId . "</div></td>";
                                echo "<td><div class='DatabaseField' ><a class='product-id btn btn-primary btn-rounded
' data-toggle='modal' data-target='#productModal' ><span class='product-id'>" . $p->Product . "</span></a></div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->ProductProperty->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ProductAndProperty.php?id=" . $p->ProductAndPropertyId . "'>" . "ویرایش" . "</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteProductAndProperty.php?id=" . $p->ProductAndPropertyId . "'>" . "حذف" . "</a></button></td>";
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
    