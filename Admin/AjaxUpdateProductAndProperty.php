<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';


$pp = new ProductAndPropertyDataSource();
$pp->open();
$p = $pp->FindOneProductAndPropertyBasedOnId($_POST['id']);
$pp->close();

$pp2 = new ProductPropertyDataSource();
$pp2->open();
$pp3 = $pp2->FindOneProductPropertyBasedOnId($p->ProductProperty->ProductPropertyId);
$pp2->close();
?>
<div class="Inputs">
    <form id="form11">
        <input type="hidden" value="<?php echo $_POST['id']; ?>" id="id" name="id"/>
        <input type="hidden" value="<?php echo $_POST['group']; ?>" id="group" name="group"/>
        <input type="hidden" value="<?php echo $p->Product; ?>" id="product" name="product"/>
        <input type="hidden" value="<?php echo $p->ProductProperty->ProductPropertyId; ?>" id="productproperty"
               name="productproperty"/>
        <table class="darker">
            <tr>
                <td></td>
                <td><span id="e-close" class="close">X</span></td>
            </tr>
            <tr>
                <td><?php echo $p->ProductProperty->Name; ?> :</td>
                <?php
                if (trim($pp3->Value) == "-" || trim($pp3->Value) == "") {
                ?>
                <td><input type="Text" id='value' name='value' class="NormalText" value="<?php echo $p->Value; ?>"/>
                </td>
            </tr>
            <?php
            } else {
                ?>
                <?php
                echo "<td>";
                echo "<select class = 'NormalText' id='value' name='value' >";
                echo "<option  value = '' ></option>";
                $n++;
                foreach (explode("-", $pp3->Value) as $p3) {
                    echo "<option ";
                    if ($p3 == $p->Value) {
                        echo ' selected ';
                    }
                    echo " value = '$p3' >" . $p3 . "</option>";
                }
                echo "</select>";
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tr>
            <tr class="SaveTr">
                <td class="SaveTd"></td>
                <td><input id="edit" type="button" class="Save" value=""/></td>
            </tr>
        </table>
    </form>
</div>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#e-close").click(function () {
            $("#edit-modal").fadeOut(250);
        });
    });

    $(document).ready(function () {
        $("#edit").click(function () {
            $("#edit-modal").fadeOut(250);
            $.ajax({
                url: 'AjaxUpdatePAP.php',
                type: 'POST',
                data: $('#form11').serialize(),
                success: function (result) {
                    $("#pdb").html(result);
                }
            });
        });
    });
</script>