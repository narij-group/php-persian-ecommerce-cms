<?php
//TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RecoveryDataSource.inc';

$cds = new CustomerDataSource();
$cds->open();

$customer = new Customer();
$customer->Email = $_POST['email2'];
$c = $cds->FindOneCustomerWithEmail($customer);
$rds = new RecoveryDataSource();
$rds->open();
$recovery = new Recovery();
$recovery->Customer = $c->CustomerId;
$r = $rds->FindOneRecoveryByCustomer($c->CustomerId);
if ($r == null) {
    $rds->Insert($recovery);
} else {
    $r->Time = time();
    $rds->Update($recovery);
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RecoveryDataSource.inc';
$customer = new Customer();
$customer->Email = $_POST['email2'];
$c = $cds->FindOneCustomerWithEmail($customer);
$recovery = new Recovery();
$recovery->Customer = $c->CustomerId;
$r = $rds->FindOneRecoveryByCustomer($c->CustomerId);
if ($r == null) {
    $rds->Insert($recovery);
} else {
    $r->Time = time();
    $rds->Update($recovery);
}

$rds->close();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';

require '../Admin/Scripts/Mailer/PHPMailerAutoload.php';
require '../Admin/Scripts/Mailer/class.smtp.php';
require '../Admin/Scripts/Mailer/class.phpmailer.php';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
$domain = $_SERVER['SERVER_NAME'];
$myfile = fopen("../Admin/Emails/Custom.html", "w");
$txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " >' . 'شما در خواست تغییر رمزعبور کرده بودید، جهت بازگردانی رمزعبور روی لینک زیر کلیک کنید :' . '<br/><br/> <a style="float:left;" href="http://' . $domain . '/index.php?key=' . md5($c->CustomerId) . '" >بازگردانی رمزعبور</a></div>
</body >
</html >
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
$mail->addAddress($_POST['email2']);


$mail->Subject = $_SERVER['HTTP_HOST'] . ' - بازگردانی رمزعبور';
$mail->msgHTML(file_get_contents('../Admin/Emails/Custom.html'), dirname(__FILE__));

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}


