<?php
require_once 'Template/top2.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$pds = new ProductDataSource();
$pds->open();
$product=$pds->FindOneProductBasedOnId($_POST['product']);
$productAndProperties = $pds->GetProperties($product->ProductId);
$pds->close();

$productAndProperty = new ProductAndPropertyDataSource();
$productAndProperty->open();
foreach ($productAndProperties as $check) {
    if ($product->SupperGroup->SupperGroupId != $check->ProductProperty->Group) {
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
$productProperties = $productProperty->FindOneSupperGroupRecords($product->SupperGroup->SupperGroupId);
$productProperty->close();

$pap = new ProductAndPropertyDataSource();
$pap->open();

foreach ($productProperties as $p2) {
    echo '<div class="form-group">';
    echo '<label class="col-sm-12 control-label">';
    echo $p2->Name . " : ";
    echo '</label>';
    echo '<div class="col-sm-12">';
    echo "<input type='hidden' class='form-control input-sm m-b-xs' value='$p2->ProductPropertyId' name='propertyname$n' id = 'propertyname$n' />";
    echo '</div>';
    echo '</div>';

    if (trim($p2->Value) == "-" || trim($p2->Value) == "") {
        ?>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="Text" id='property<?php echo $n; ?>'
                       name='property<?php echo $n; ?>'
                       class="form-control input-sm m-b-xs"
                       id="value" name="value"
                       value="<?php echo $pap->FindValue($product->ProductId, $p2->ProductPropertyId) ?>"/>
            </div>
        </div>
        <?php
        $n++;
    } else {
        ?>
        <?php
        echo '<div class="form-group">';
        echo '<div class="col-sm-12">';
        echo "<select class = 'form-control m-b' style='width: 100%' id='property$n' name='property$n' >";
        echo "<option  value = '' ></option>";
        $n++;
        foreach (explode("-", $p2->Value) as $p3) {
            echo "<option ";
            if ($pap->FindValue($product->ProductId, $p2->ProductPropertyId) == $p3) {
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