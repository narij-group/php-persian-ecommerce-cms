<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
$c = new PurchaseBasket();
$pbds = new PurchaseBasketDataSource();
$pbds->open();
$p = $pbds->FindOneCustomerLastPurchaseBasketItem($_COOKIE ['CustomerId']);
$pbds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

$productcolor = new ProductColorDataSource();
$productcolor->open();
$productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
$productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
$productcolor->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
$productcolor = new ProductColorDataSource();
$productcolor->open();

$productcolor2->Color = $productcolor1->Color->ColorListId;
$SelectedColor = $productcolor1->ProductColorId;
$ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
$productcolor->close();

for ($i = 1; $i <= $ColorQuantity; $i++) {
    echo "<option value='$i' ";
    echo ">$i</option>";
}

?>
<Script>
    $("#quantity_submit_btn").click(function () {
        $("#quantity_modal").fadeOut(250);
        $("#modalback").fadeOut(500);
        $.ajax({
            url: 'AjaxSearch/UpdateCartPrice.php',
            type: 'POST',
            data: {
                quantity: $('#quantity').val(),
                basket: <?php echo $p->PurchaseBasketId; ?> },
            success: function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/UpdateCartPrice.php',
                    data: {rereshitemsnum: 1},
                    success: function (data) {
                        $('#total_items').val(data);
                    }
                });
            }
        });
    });
</Script>

