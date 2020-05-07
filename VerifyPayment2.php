<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/FactorProductDataSource.inc";
$message = 0;
if (isset($_GET['Authority']) && isset($_GET['Status'])) {
    $fp = new FactorProductDataSource();
    $fp->open();

    $fps = $fp->FindFactorProductsOnAuthority($_GET['Authority']);
    foreach ($fps as $f) {
        $factor_amount = $f->Amount;
    }


    $MerchantID = '4ae923a0-6a2d-11e7-bb3b-000c295eb8fc'; //Required
    $Amount = $factor_amount; //Amount will be based on Toman
    $Authority = $_GET['Authority'];

    if ($_GET['Status'] == 'OK') {
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification(
            [
                'MerchantID' => $MerchantID,
                'Authority' => $Authority,
                'Amount' => $Amount,
            ]
        );

        if ($result->Status == 100) {
            foreach ($fps as $f) {
                $fp->UpdatePaymentMethod($f->FactorProductId, 1);
                $fp->UpdatePaymentStatus($f->FactorProductId, 1);
                $fp->UpdateRefId($f, $result->RefID);
                $tracecode = $f->TraceCode;
                $email = $f->Factor->Customer->Email;
                $mobile = $f->Factor->Customer->Mobile;
            }
        }
        $message = 1;
    }

    if ($message == 1) {
        if ($settings->SMS == 1) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SMSDataSource.inc';
            $value = 'سفارش شما با کد پیگیری ' . $tracecode . ' با موفقیت پرداخت شد.';
            $sms = new SMSDataSource();
            $sms->recipientNumber = "'" . $mobile . "'";
            $sms->message = urlencode($value);
            $sms->enqueueSample();
        }

        if ($settings->isEmail == 1) {
            $email_message = "سفارش شما با موفقیت پرداخت شد! شما میتوانید از طریق حساب کاربری خود وضعیت سفارش و ... را پیگیری کنید. کد پیگیری شما : " . $tracecode . "";
            ?>
            <script>
                $(document).ready(function () {
                    $.ajax({
                        url: 'PurchaseEmail.php',
                        type: 'POST',
                        data: {text: '<?php echo $email_message; ?>', email: "<?php echo $email; ?>"},
                        success: function () {
                        }
                    });
                });
            </script>
            <?php
        }
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SettingsDataSource.inc';

        require_once 'Admin/Scripts/Mailer/PHPMailerAutoload.php';
        require_once 'Admin/Scripts/Mailer/class.smtp.php';
        require_once 'Admin/Scripts/Mailer/class.phpmailer.php';
        $setting = new SettingsDataSource();
        $setting->open();
        $settings = $setting->Fill();
        $setting->close();
        $domain = $_SERVER['SERVER_NAME'];
        $myfile = fopen("Admin/Emails/Custom.html", "w");
        $txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="direction: rtl;"> 
<div style="padding: 20px;  width: auto;  font-size: 11pt; line-height:25px;  text-align: right;  font-family: Tahoma; " >سفارشی با کد پیگیریه ' . $tracecode . '  پرداخت شد!. </div></div>
</body>
</html>
        ';

        fwrite($myfile, $txt);
        fclose($myfile);

        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $settings->SMTP;
        $mail->SMTPAuth = true;
        $mail->Username = $settings->Email;
        $mail->Password = $settings->Password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $settings->SMTPPort;


        $mail->setFrom($settings->Email, $settings->Email);
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/UserDataSource.inc';
        $user = new UserDataSource();
        $user->open();
        $users = $user->FindAdmins();
        $user->close();
        foreach ($users as $u) {
            $mail->addAddress($u->Email);
        }


        $mail->Subject = ' سفارش جدید ';
        $mail->msgHTML(file_get_contents('Admin/Emails/Custom.html'), dirname(__FILE__));

        if (!$mail->send()) {
            header('location:UserProfile.php');
        } else {
            header('location:UserProfile.php');
        }
    }
} else {
    header('location:UserProfile.php');
}