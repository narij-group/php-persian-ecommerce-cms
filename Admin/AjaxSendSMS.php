<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
if (trim($_POST['value']) != "") {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SMSDataSource.inc';
    $customer = new CustomerDataSource();
    $customer->open();
    $customers = $customer->Fill();
    $customer->close();

    foreach ($customers as $c) {
        $sms = new SMS();
        $sms->recipientNumber = "'" . $c->Mobile . "'";
        $sms->message = urlencode($_POST['value']);
        $sms->enqueueSample();
    }
}