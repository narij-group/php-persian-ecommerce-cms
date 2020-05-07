<?php
require_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$price = new PriceDataSource();
$price->open();
$items = $_POST['item'] + 50;
$prices = $price->LimitedFill($items);
$total = $price->Fill();
$price->close();
$postsCounter = 0;
?>
<script>
    $(document).ready(function () {
        $('#loadmore').click(function () {
            $('.modalback').fadeIn(0);
            $.ajax({
                url: 'LoadMorePrices.php',
                type: 'POST',
                data: {item: <?php echo $items; ?>},
                success: function (result) {
                    $("#db").html(result);
                    $('.modalback').fadeOut(0);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                    $('.modalback').fadeOut(0);
                }
            });
        });
    });

</script>
<?php
$postsCounter = 0;
?>

<div class="Database">

    <input type="text" class="form-control input-sm m-b-xs" id="filter"
           placeholder="جستجو در لیست موجود در این صفحه">
    <table class="footable table table-stripped" data-page-size="1000000000"
           data-filter=#filter>
        <thead>
        <tr>
            <th>شناسه</th>
            <th> محصول</th>
            <th> قیمت</th>
            <th data-hide="phone,tablet"> تاریخ</th>
            <th data-hide="phone,tablet"> کاربر</th>
            <?php
            if ($role->EditPrice == 1) {
                ?>
                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                <?php
            }
            if ($role->DeletePrice == 1) {
                ?>
                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <?php
        $postsCounter = 0;
        foreach ($prices as $p) {
            $postsCounter++;
            echo "<tr>";
            echo "<td><div class='DatabaseField' >" . $p->PriceId . "</div></td>";
            echo "<td><div class='DatabaseField' ><a class='product-id btn btn-primary btn-rounded' data-toggle='modal' data-target='#productModal' ><span class='product-id'>" . $p->Product . "</span></a></div></td>";
            echo "<td><div class='DatabaseField' >" . number_format($p->Value) . ' تومان' . "</div></td>";
            echo "<td><div class='DatabaseField' >" . $p->Date . "</div></td>";
            echo "<td><div class='DatabaseField' >" . $p->User->Name . " " . $p->User->Family . "</div></td>";
            if ($role->EditPrice == 1) {
                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Price.php?";
                if (isset($_GET['id']) == TRUE) {
                    echo "pid=$p->Product&";
                }
                echo "id=$p->PriceId'>ویرایش</a></button></td>";
            }
            if ($role->DeletePrice == 1) {
                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operatePrice.php?";
                if (isset($_GET['id']) == TRUE) {
                    echo "pid=$p->Product&";
                }
                echo "id=$p->PriceId'>حذف</a></button></td>";
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
    <?php
    $postsCounter = 0;
    foreach ($total as $p) {
        $postsCounter++;
    }
    ?>
</div>

<?php
$postsCounter = 0;
foreach ($total as $p) {
    $postsCounter++;
}

if ($postsCounter > $items) {
    ?>
    <input id="loadmore" type="button" name="loadmore" class="load-more2 btn btn-warning btn-w-m" value="بارگذاری موارد بیشتر..."/>
    <?php
}
?>
</div>