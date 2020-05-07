<meta charset="UTF-8">
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<?php
require_once 'Template/top2.php';
if ($role->EditFactorProduct != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';


if ($_GET['request'] == 'approved') {
    $FactorProduct = new FactorProductDataSource();
    $FactorProduct->open();
    $records = $FactorProduct->FillByCode($_GET['code']);
    foreach ($records as $record) {
        $email = $record->Factor->Customer->Email;
        $FactorProduct->UpdatePaymentStatus($record->FactorProductId, 1);
    }

    $FactorProduct->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/BillDataSource.php";
    $bill = new BillDataSource();
    $bill->open();
    $b = $bill->FindByCode($_GET['code']);
    $bill->UpdateStatus($b, 2);
    $bill->close();

} else {
    $FactorProduct = new FactorProductDataSource();
    $FactorProduct->open();
    $records = $FactorProduct->FillByCode($_GET['code']);
    foreach ($records as $record) {
        $email = $record->Factor->Customer->Email;
        $FactorProduct->UpdatePaymentStatus($record->FactorProductId, 5);
    }
    $FactorProduct->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/BillDataSource.php";
    $bill = new BillDataSource();
    $bill->open();
    $b = $bill->FindByCode($_GET['code']);
    $bill->UpdateStatus($b, 3);
    $bill->close();
}

header('Location:FactorProducts.php?code=' . $_GET['code'] . '&request=' . $_GET['request']);