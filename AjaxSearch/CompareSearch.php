<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductDataSource.inc";


$product = new ProductDataSource();
$product->open();
$products = $product->SearchProducts($_POST['string']);
$product->close();
if ($_POST['string'] != "") {
    echo " <table>";
    foreach ($products as $p) {
        ?>
        <tr class="item-tr" id="<?php echo $p->ProductId; ?>">
            <td><img src="<?php echo $p->Image; ?>"/></td>
            <td>
                <div>
                    <?php
                    if (strlen($p->Name) > 120) {
                        $str = substr($p->Name, 0, 120) . '...';
                        echo $str;
                    } else {
                        echo $p->Name;
                    }
                    ?>
                </div>
            </td>
        </tr>
        <?php
    }
    if ($products == null) {
        ?>
        <tr>
            <td>محصولی با این نام وجود ندارد !</td>
        </tr>
        <?php
    }
    echo " </table > ";
}
?>
<script>

    $(document).ready(function () {
        $(".compare-search").focusout(function () {
            $(".searches").fadeOut();
        });
        $(".compare-search").focusin(function () {
            $(".searches").fadeIn();
        });
        $(".compare-search2").focusout(function () {
            $(".searches2").fadeOut();
        });
        $(".compare-search2").focusin(function () {
            $(".searches2").fadeIn();
        });
        $(".compare-search3").focusout(function () {
            $(".searches3").fadeOut();
        });
        $(".compare-search3").focusin(function () {
            $(".searches3").fadeIn();
        });
        $(".item-tr").click(function () {
            var ID = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: 'AddToCompare.php',
                data: {id: ID},
                success: function () {
                    location.reload();
                }
            });
        });
    });

</script>
