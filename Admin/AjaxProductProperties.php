<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .   '../ClassesEx/datasource/ProductPropertyDataSource.inc';

if ($role->ProductProperties != 1) {
    header('Location:Index.php');
    die();
}

$productProperty = new ProductPropertyDataSource();
$productProperty ->open();
$productProperties = $productProperty->FindOneSupperGroupRecords($_POST['suppergroup']);
$productProperty ->close();

setcookie(COOKIE_SUPPER_GROUP_ID, $_POST['suppergroup'], time() + 86400);
?>
<div class="db-cover" id="wait">        
    <span class="loading-title <?php
    if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
        echo " SBackground'";
    } else {
        echo " GBackground'";
    }
    ?>">Loading...</span>
    <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>                    
</div>
<table class="footable table table-stripped" data-page-size="1000000000"
       data-filter=#filter>
    <thead>
    <tr>
        <th>شناسه</th>
        <th> نام</th>
        <th> محتوا</th>
        <!--                    <th> زیر زیرمجموعه</th>-->
        <?php
        if ($role->EditProductProperty == 1) {
            ?>
            <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
            <?php
        }
        if ($role->DeleteProductProperty == 1) {
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
    foreach ($productProperties as $p) {
        $postsCounter++;
        echo "<tr>";
        echo "<td><div class='DatabaseField' >" . $p->ProductPropertyId . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
//        echo "<td><div class='DatabaseField' >" . $p->Group->Name . "</div></td>";
        if ($role->EditProductProperty == 1) {
            echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ProductProperty.php?id=" . $p->ProductPropertyId . "'>" . "ویرایش" . "</a></button></td>";
        }
        if ($role->DeleteProductProperty == 1) {
            echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteProductProperty.php?id=" . $p->ProductPropertyId . "'>" . "حذف" . "</a></button></td>";
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
<script>
    $(document).ready(function() {
        $('#add').attr('href', 'ProductProperty.php?gid=<?php echo $_POST['suppergroup']; ?>')
    });
</script>