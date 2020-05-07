<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
?>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('#add').click(function () {
            $.ajax({
                type: 'POST',
                url: 'AjaxProductAndPropertiesInsert.php',
                data: $('#myForm10').serialize(),
                success: function () {
//                    $("#success-msg").fadeIn(250);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        timeOut: 5000
                    };
                    toastr.success('ویژگی ها با موفقیت ثبت شدند!', 'پیغام');
                    $('#closeModal2').click(function(){return true;}).click();
//                    $("#p-info").fadeOut(250);
//                    $("#modalback").fadeOut(250);
//                    setTimeout(function () {
//                        $("#success-msg").fadeOut(250);
//                    }, 7000);
                },
                error: function () {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        toastr: 'warning',
                        timeOut: 5000
                    };
                    toastr.warning('مشکلی به وجود آمد، لطفا دوباره امتحان کنید.', 'خطا');
//                    $("#error-msg").fadeIn(250);
//                    setTimeout(function () {
//                        $("#error-msg").fadeOut(250);
//                    }, 7000);
                }
            });

        });
        $("#pp-btn").click(function () {
            $.ajax({
                url: 'AjaxInsertProductProperty.php',
                type: 'POST',
                data: {suppergroup: <?php echo $_POST['suppergroup']; ?>},
                success: function (result) {
                    $("#pp-modal").html(result);
//                    $("#pp-modal").fadeIn(500);
                }
            });
        });
//        $(".closebtn").click(function () {
//
//            $("#p-info").fadeOut(250);
//            $("#modalback").fadeOut(250);
//
//
//        });
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span
                aria-hidden="true" id="closeModal2">&times;</span><span
                class="sr-only">Close</span></button>
    <h4 class="modal-title">ویژگی محصول
    </h4>
</div>
<div class="modal-body">
    <a id="pp-btn" data-toggle="modal" data-target="#addModal">
        <button class="btn btn-primary btn-w-m" type="button" data-dismiss="modal"><i class="fa fa-plus"></i>
            افزودن ویژگی جدید
        </button>
    </a>
    <br>
    <br>
    <div class="Inputs">
        <form id="myForm10">
            <div class="closebtn"></div>
            <input type="hidden" class="NormalText" id="product" name="product"
                   value="<?php echo $_POST['productId']; ?>"/>
            <div class="alert alert-warning">
                توجه : اگر خاصیتی در محصول مورد نظر صدق نمی کند آن را خالی بگذارید .
            </div>
            <div class="alert alert-warning">
                توجه : اگر خاصیتی از محصول را میخواهید حذف کنید، کافی است محتوای آن را خالی کنید!
            </div>

            <fieldset class="form-horizontal">
                <?php
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

                $product = new ProductDataSource();
                $product->open();
                $productAndProperties = $product->GetProperties($_POST['productId']);
                $product->close();


                $productAndProperty = new ProductAndPropertyDataSource();
                $productAndProperty->open();
                foreach ($productAndProperties as $check) {
                    if ($_POST['suppergroup'] != $check->ProductProperty->Group) {
                        $productAndProperty->Delete($check->ProductAndPropertyId);
                    }
                }
                $productAndProperty->close();

                ?>
                <?php
                $n = 0;
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

                $productProperty = new ProductPropertyDataSource();
                $productProperty->open();
                $productProperties = $productProperty->FindOneSupperGroupRecords($_POST['suppergroup']);
                $productProperty->close();


                $pap = new ProductAndPropertyDataSource();
                $pap->open();

                foreach ($productProperties as $p2) {
                    echo '<div class="form-group">';
                    echo '<label class="col-sm-12 control-label">';
                    echo $p2->Name . " : ";
                    echo '</label>';
                    echo '<div class="col-sm-12">';
                    echo "<input type='hidden' class='form-control input-sm m-b-xs' value='$p2->ProductPropertyId' name='fieldname$n' id = 'fieldname$n' />";
                    echo '</div>';
                    echo '</div>';

                    if (trim($p2->Value) == "-" || trim($p2->Value) == "") {
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="Text" id='field<?php echo $n; ?>' name='field<?php echo $n; ?>'
                                       class="form-control input-sm m-b-xs"
                                       id="value" name="value"
                                       value="<?php echo $pap->FindValue($_POST['productId'], $p2->ProductPropertyId) ?>"/>
                            </div>
                        </div>
                        <?php
                        $n++;
                    } else {
                        ?>
                        <?php
                        echo '<div class="form-group">';
                        echo '<div class="col-sm-12">';
                        echo "<select class = 'form-control m-b' style='width: 100%' id='field$n' name='field$n' >";
                        echo "<option  value = '' ></option>";
                        $n++;
                        foreach (explode("-", $p2->Value) as $p3) {
                            echo "<option ";
                            if ($pap->FindValue($_POST['productId'], $p2->ProductPropertyId) == $p3) {
                                echo "selected";
                            }
                            echo " value = '$p3' >" . $p3 . "</option>";
                        }
                        echo "</select>";
                        echo '</div>';
                        echo '</div>';
                    }
                }
                $pap->close();
                ?>
            </fieldset>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">بستن
    </button>
    <button type="button" id="add" class="btn btn-primary"
            data-dismiss="modal">تایید
    </button>
</div>
</form>
