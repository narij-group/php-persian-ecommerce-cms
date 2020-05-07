<!DOCTYPE html>
<?php
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
$productAndProperty = new ProductAndProperty();
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new ProductAndPropertyDataSource();
    $p->open();
    $productAndProperty = $p->FindOneProductAndPropertyBasedOnId($_GET['id']);
    $p->close();
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>ویژگی محصول</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Property</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ProductAndProperties.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست ویژگی ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            ویژگی محصول
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <?php
                                //---------------------------------------------ADD-----------------------------------------------------//
                                if ($cm == "add") {
                                ?>
                                <form action="InsertProductAndProperty.php" method="post">
                                    <input type="hidden" class="NormalText" id="product" name="product"
                                           value="<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>"/>
                                    <div class="alert alert-warning">
                                        توجه : اگر خاصیتی در محصول مورد نظر صدق نمی کند آن را خالی بگذارید .
                                    </div>

                                    <fieldset class="form-horizontal">

                                        <?php
                                        $n = 0;
                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
                                        $product = new ProductDataSource();
                                        $product->open();
                                        $product2 = $product->FindOneProductBasedOnId($_SESSION[SESSION_INT_PRODUCT_ID]);
                                        $product->close();


                                        //TODO ERROR UNKNOWN

                                        $productProperty = new ProductPropertyDataSource();
                                        $productProperty->open();
                                        $productProperties = $productProperty->FindOneGroupRecords($product2->Group->GroupId);
                                        foreach ($productProperties as $pp) {

                                        }
                                        foreach ($productProperties

                                        as $p2) {
                                        echo '<div class="form-group">';
                                        echo '<label class="col-sm-12 control-label">' . $p2->Name . '</label>' . ' : ';
                                        echo "<input type='hidden' value='$p2->ProductPropertyId' name='fieldname$n' id = 'fieldname$n' />";
                                        //                                        echo '</div>';

                                        if (trim($p2->Value) == "-" || trim($p2->Value) == "") {
                                        ?>
                                        <div class="col-sm-12">
                                            <input type="Text" id='field<?php echo $n; ?>'
                                                   name='field<?php echo $n; ?>'
                                                   class="form-control input-sm m-b-xs" id="value" name="value"
                                                   value="<?php echo $productAndProperty->Value; ?>"/>
                                        </div>
                            </div>
                            <?php
                            $n++;
                            } else {
                                ?>
                                <?php
                                echo '<div class="col-sm-12">';
                                echo "<select class = 'form-control m-b' id='field$n' name='field$n' >";
                                echo "<option  value = '' ></option>";
                                $n++;
                                foreach (explode("-", $p2->Value) as $p3) {
                                    echo "<option  value = '$p3' >" . $p3 . "</option>";
                                }
                                echo "</select>";
                                echo '</div>';
                                echo '</div>';
                            }
                            }
                            if ($cm == "add") {
                                ?>
                                </fieldset>
                                <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                            class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>
                                <?php
                            }
                            }
                            //---------------------------------------------Edit-----------------------------------------------------//
                            if ($cm == "edit") {
                            ?>
                            <form action="UpdateProductAndProperty.php" method="post">
                                <input type="hidden" id="id" name="id"
                                       value="<?php echo $productAndProperty->ProductAndPropertyId; ?>"/>
                                <input type="hidden" class="NormalText" id="product" name="product"
                                       value="<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>"/>
                                <div class="alert alert-warning">
                                    توجه : اگر خاصیتی در محصول مورد نظر صدق نمی کند آن را خالی بگذارید .
                                </div>

                                <div class="form-horizontal">
                                    <?php
                                    $n = 0;
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
                                    $productProperty = new ProductPropertyDataSource();
                                    $productProperty->open();
                                    $productProperties = $productProperty->FindOneProductPropertyBasedOnId($productAndProperty->ProductProperty->ProductPropertyId);
                                    $productProperty->close();
                                    echo '<div class="form-group">';
                                    echo '<label class="col-sm-12 control-label">' . $productProperties->Name . '</label>' . ' : ';
                                    echo "<input type='hidden' value='$productProperties->ProductPropertyId' name='productPropertyId' id = 'productPropertyId' />";
                                    echo '</td>';
                                    if (trim($productProperties->Value) == "-" || trim($productProperties->Value) == "") {
                                    ?>
                                    <div class="col-sm-12">
                                        <input type="Text" id='value' name='value' class="form-control input-sm m-b-xs"
                                               id="value"
                                               name="value"
                                               value="<?php echo $productAndProperty->Value; ?>"/>
                                    </div>
                                </div>
                                <?php
                                $n++;
                                } else {
                                    ?>
                                    <?php
                                    echo '<div class="col-sm-12">';
                                    echo "<select class = 'form-control m-b' id='value' name='value' >";
                                    echo "<option  value = '' ></option>";
                                    $n++;
                                    foreach (explode("-", $productProperties->Value) as $p3) {
                                        echo "<option ";
                                        if ($productAndProperty->Value == $p3) {
                                            echo " selected ";
                                        }
                                        echo "value = '$p3' >" . $p3 . "</option>";
                                    }
                                }
                                echo "</select>";
                                echo '</div>';
                                echo '</div>';
                                }

                                if ($cm == "edit") {
                                ?>
                                </fieldset>
                                <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                            class="fa fa-check"></i><strong>تایید</strong></button>
                            </form>
                        <?php
                        }
                        ?>
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
