<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
$factorproduct = new FactorProductDataSource();
$factorproduct->open();
$code = str_replace('btn', '', $_POST['code']);
$factorproducts = $factorproduct->FillByCode($code);
foreach ($factorproducts as $f) {
    $amount = $f->Amount;
}

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';
$bill = new Bill();
$b = new BillDataSource();
$b->open();
if ($b->FindByCode($code) != null) {
    $bill = $b->FindByCode($code);
}
$b->close();
?>

<span class="Title">فیش بانکی</span>
<form action="Internal Inserting/InsertBill.php" method="post">
    <input type="hidden" name="tracecode" value="<?php echo $code; ?>"/>
    <table>
        <tr>
            <td><input type="text" readonly value="<?php echo number_format($amount) . ' تومان'; ?>" id="amount"
                       class="single-input" name="amount" placeholder="مبلغ واریزی"/></td>
        </tr>
        <tr>
            <td><input type="text" value="<?php echo $bill->Date; ?>" id="date" class="single-input" name="date"
                       placeholder="تاریخ"/></td>
        </tr>
        <tr>
            <td><input type="text" value="<?php echo $bill->Code; ?>" id="code" class="single-input" name="code"
                       placeholder="شماره فیش"/></td>
        </tr>
        <tr>
            <td><input type="text" value="<?php echo $bill->Bank; ?>" id="bank" class="single-input" name="bank"
                       placeholder="بانک"/></td>
        </tr>
        <tr>
            <td><input type="text" value="<?php echo $bill->Comment; ?>" id="comment" class="single-input"
                       name="comment" placeholder="توضیحات"/></td>
        </tr>

    </table>
    <div style="position:relative; text-align: center;">
        <input type="submit" id="receiptbutton" value="ثبت فیش"/>
        <img class="modal-loader" id="recieptloader" src="Admin/Template/Images/gifs/loading.gif"/>
    </div>
</form>