<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$product = new ProductDataSource();
$product->open();
$p = $product->FindOneProductBasedOnId($_POST['product']);
$product->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';

require_once '../Admin/Scripts/Mailer/PHPMailerAutoload.php';
require_once '../Admin/Scripts/Mailer/class.smtp.php';
require_once '../Admin/Scripts/Mailer/class.phpmailer.php';
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
<div style="padding: 20px;  width: auto;  font-size: 11pt; line-height:25px;  text-align: right;  font-family: Tahoma; " >محصول ' . $p->Name . ' به شناسه ' . $p->ProductId . ' ناموجود شد!</div></div>
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
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';
$user = new UserDataSource();
$user->open();
$users = $user->FindAdmins();
$user->close();
foreach ($users as $u) {
    $mail->addAddress($u->Email);
}


$mail->Subject = ' ناموجودی محصول ';
$mail->msgHTML(file_get_contents('../Admin/Emails/Custom.html'), dirname(__FILE__));

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo 'SENT!';
}