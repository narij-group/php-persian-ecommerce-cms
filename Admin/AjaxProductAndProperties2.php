<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
?>
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
    if ($_POST['group'] != $check->ProductProperty->Group) {
        $productAndProperty->Delete($check->ProductAndPropertyId);
    }
}
$productAndProperty->close();
?>
<script type="text/javascript">
    function deleteConfirm() {
        return confirm("آیا میخواهید این رکورد را حذف کنید ؟");
    }

    function deleteConfirmUser() {
        return confirm("آیا میخواهید این کاربر را حذف کنید ؟ اگر این کاربر را حذف کنید تمامی محصولات و ... که به سایت اضافه کرده است نیز حذف خواهند شد.");
    }
</script>
<div class="modalback" id="modalback"></div>
<div class="product-info" id="p-info"></div>
<div class="edit-modal" id="edit-modal"></div>
<div class="edit-modal" id="pp-modal"></div>
<div class="Centerer2">
    <div class="MainTitle2"><span <?php
        if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
            echo "class='SBackground'";
        } else {
            echo "class='GBackground'";
        }
        ?> >Properties</span><img src="Template/Images/trigger2.png" alt=""/></div>
    <div class="ProfileBar">
        <div class="Shortcut"><a id="add2" name="add2"><img src="Template/Images/Add.png" alt=""/></a></div>
    </div>
    <div class="title-btn2"><a id="pp-btn">افزودن ویژگی جدید</a></div>
    <div class="Database" id="pdb">
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
    </div>
</div>
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
        $("#pp-btn").click(function () {
            var id = $(this).text();
            $.ajax({
                url: 'AjaxInsertProductProperty.php',
                type: 'POST',
                data: {group: <?php echo $_POST['group']; ?>},
                success: function (result) {
                    $("#pp-modal").html(result);
                    $("#pp-modal").fadeIn(500);
                }
            });
        });
        $(".delete-btn").click(function () {
            var id = $(this).text();
            $.ajax({
                url: 'AjaxDeleteProductAndProperty.php',
                type: 'POST',
                data: {id: id, product: <?php echo $_POST['productId']; ?>},
                success: function (result) {
                    $("#pdb").html(result);
                }
            });
        });
        $("#add2").click(function () {
            $("#p-table").fadeOut(250);
            $.ajax({
                url: 'AjaxProductAndProperties.php',
                type: 'POST',
                data: {productId: <?php echo $_POST['productId']; ?>, group: <?php echo $_POST['group']; ?>},
                success: function (result) {
                    $("#p-info").html(result);
                    $("#p-info").fadeIn(500);
                }
            });
        });
    });
</script>
