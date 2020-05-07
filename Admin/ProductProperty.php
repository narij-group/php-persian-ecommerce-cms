<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
$productProperty = new ProductProperty();
if (isset($_GET['id'])) {
    if ($role->EditProductProperty != 1) {
        header('Location:Index.php');
        die();
    }

    $p = new ProductPropertyDataSource();
    $p->open();
    $productProperty = $p->FindOneProductPropertyBasedOnId($_GET['id']);
    $p->close();
} else {
    if ($role->InsertProductProperty != 1) {
        header('Location:Index.php');
        die();
    }
}

?>
<?php

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>ویژگی محصول</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product Property</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ProductProperties.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست ویژگی محصولات
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            ویژگی محصول
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning">
                                آموزش: اگر می خواهید خاصیت در هنگام افزودن محصول به صورت دلخواه انتخاب شود تنها '-' در
                                محتوا بنویسید.
                            </div>
                            <div class="alert alert-warning">
                                آموزش 2: اگر می خواهید خاصیت به صورت گزینه ای نمایش داده شود، گزینه ها را با '-' جدا
                                کنید.
                            </div>
                            <div class="alert alert-warning">
                                آموزش 3: اگر میخواهید خاصیت در سایت به صورت "تیک" و "ضربدر" نمایش داده شود، محتوا را
                                "دارد-ندارد" تنظیم کنید!
                            </div>
                            <div class="Inputs">
                                <form action="operateProductProperty.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $productProperty->ProductPropertyId; ?>"/>
                                    <?php
                                    if (isset($_GET['gid']) == true) {
                                        ?>
                                        <input type="hidden" id="subgroup" name="subgroup"
                                               value="<?php echo $_GET['gid']; ?>"/>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="hidden" id="subgroup" name="subgroup"
                                               value="<?php echo $productProperty->Group->SupperGroupId; ?>"/>
                                        <?php
                                    }
                                    ?>

                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $productProperty->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                محتوا :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="value" name="value"
                                                       value="<?php echo $productProperty->Value; ?>"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
