<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
$productcolor = new ProductColor();
if (isset($_GET['id'])) {
    $p = new ProductColorDataSource();
    $p->open();
    $productcolor = $p->FindOneProductColorBasedOnId($_GET['id']);
    $p->close();
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>رنگ محصول</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product Color</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ProductColors.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست رنگ های محصول
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            رنگ محصول
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="operateProductColor.php" method="post">
                                    <input type="hidden" id="id" name="id" value="<?php echo $productcolor->ProductColorId; ?>"/>
                                    <?php
                                    if (isset($_GET['pid']) == TRUE) {
                                        ?>
                                        <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid'] ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                رنگ :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name" value="<?php
                                                if (isset($productcolor->Name) == TRUE) {
                                                    echo $productcolor->Name;
                                                }
                                                ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                تعداد :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Number" min="0" class="form-control input-sm m-b-xs" id="quantity" name="quantity"
                                                       value="<?php
                                                       if (isset($productcolor->Quantity) == TRUE) {
                                                           echo $productcolor->Quantity;
                                                       }
                                                       ?>"/>
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
