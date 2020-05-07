<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$pp = new ProductAndPropertyDataSource();
$pp->open();
$pp->Delete($_POST['id']);
$pp->close();

$product = new ProductDataSource();
$product->open();
$productAndProperties = $product->GetProperties($_POST['product']);
$product->close();

?>
<table border="0">
    <tr>
        <!--<th>شناسه </th>-->
        <th> ویژگی</th>
        <th>محتوا</th>
        <th id="th1"></th>
        <th id="th2"></th>
    </tr>
    <?php
    $postsCounter = 0;
    foreach ($productAndProperties as $p) {
        $postsCounter++;
        echo "<tr>";
//            echo "<td><div class='DatabaseField' >" . $p->ProductAndPropertyId . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $p->ProductProperty->Name . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
        echo "<td><div class='Edit'><a class='edit-btn' >" . "$p->ProductAndPropertyId" . "</a></div></td>";
        echo "<td><div class='Delete'><a class='delete-btn' >" . "$p->ProductAndPropertyId" . "</a></div></td>";
        echo "</tr>";
    }
    ?>
</table>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var id = $(this).text();
            $.ajax({
                url: 'AjaxUpdateProductAndProperty.php',
                type: 'POST',
                data: {id: id},
                success: function (result) {
                    $("#edit-modal").html(result);
                    $("#edit-modal").fadeIn(500);
                }
            });
        });
    });
    $(".delete-btn").click(function () {
        var id = $(this).text();
        $.ajax({
            url: 'AjaxDeleteProductAndProperty.php',
            type: 'POST',
            data: {id: id},
            success: function (result) {
                $("#pdb").html(result);
            }
        });
    });
</script>