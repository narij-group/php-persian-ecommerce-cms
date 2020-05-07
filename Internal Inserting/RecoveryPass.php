<?php
if ($_POST['newpass'] != $_POST['newpassrepeat']) {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#fpass2').fadeIn(250);
            $("#modalback").fadeIn(1000);
            $("#recovery-error-msg").fadeIn(250);
            setTimeout(function () {
                $("#recovery-error-msg").fadeOut(250);
            }, 5000);
        });
    </script>
    <?php
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RecoveryDataSource.inc';
$customer = new CustomerDataSource();
$customer->open();
$customers = $customer->Fill();
//$customer->close();
foreach ($customers as $c) {
    if (md5($c->CustomerId) == $_POST['key']) {
        $selectedCustomer = $c;
    }
}
$selectedCustomer->Password = md5($_POST['newpass']);

$recovery = new RecoveryDataSource();
$recovery->open();
$r = $recovery->FindOneRecoveryByCustomer($selectedCustomer->CustomerId);
//$recovery->close();
if ($recovery->isUserAllowed($r->Customer) == true) {
    $r->Time = time() - 86400;
    $recovery->Update($r);
    $customer->Update($selectedCustomer);
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#recovery-success-msg2").fadeIn(250);
            setTimeout(function () {
                $("#recovery-success-msg2").fadeOut(250);
                window.location.href = "../index.php";
            }, 5000);
        });
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#fpass").fadeIn(250);
            $("#modalback").fadeIn(500);
            $("#recovery-error-msg2").fadeIn(250);
            setTimeout(function () {
                $("#recovery-error-msg2").fadeOut(250);
            }, 5000);
        });
    </script>
    <?php
}