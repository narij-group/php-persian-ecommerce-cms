<?php
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
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt; line-height:20px;  text-align: right;  font-family: Arial; " >' . $_POST["text"] . '<br/><br/><a style="float:left;  color:#fff; background-color:#09f; padding:7px; border-radius:50px; font-family:Arial;" href="http://' . $domain . '/UserProfile.php">حساب کاربری</a></div></div>
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
$mail->addAddress($_POST['email']);


$mail->Subject = $_SERVER['HTTP_HOST'] . ' - خرید';
$mail->msgHTML(file_get_contents('Admin/Emails/Custom.html'), dirname(__FILE__));

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

