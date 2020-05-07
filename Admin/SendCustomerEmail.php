<?php
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
$customer = new CustomerDataSource();
$customer->open();
$customers = $customer->Fill();
$customer->close();
require 'Scripts/Mailer/PHPMailerAutoload.php';
require 'Scripts/Mailer/class.smtp.php';
require 'Scripts/Mailer/class.phpmailer.php';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
$domain = $_SERVER['SERVER_NAME'];
$_GET['emailcontent'] = str_replace("PostImages", "$domain/PostImages", $_GET['emailcontent']);
foreach ($customers as $f) {
    $myfile = fopen("Emails/Custom.html", "w");
    $txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto; text-align: right;  >' . $_GET["emailcontent"] . '</div> 
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
    $mail->addAddress($f->Email);


    $mail->Subject = $_SERVER['HTTP_HOST'] . ' - پیام برای شما';
    $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        $_SESSION[SESSION_BOOL_EMAIL_SENT] = false;
        header('location:Customers.php');
    } else {
        $_SESSION[SESSION_BOOL_EMAIL_SENT] = true;
        header('location:Customers.php');
    }
}
