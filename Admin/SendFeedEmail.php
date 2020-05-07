<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
$feed = new FeedDataSource();
$feed->open();
$feeds = $feed->Fill();
$feed->close();

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

if (isset($_GET['feed'])) {
    foreach ($feeds as $f) {
        $myfile = fopen("Emails/Custom.html", "w");
        $txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  text-align: right; " >' . $_GET["emailcontent"] . ' <br/><br/><a style="float:left;  color:#333; font-family:Arial;" href="http://' . $domain . '/UnsubscribeFeed.php?id=' . $f->FeedId . '">غیر فعال کردن خبرنامه</a></div>
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


        $mail->Subject = $_SERVER['HTTP_HOST'] . ' - خبرنامه';
        $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            $_SESSION[SESSION_BOOL_FEED_EMAIL_SENT] = false;
//            header('location:Feeds.php');
        } else {
            $_SESSION[SESSION_BOOL_FEED_EMAIL_SENT] = true;
//            header('location:Feeds.php');
        }
    }
}

if (isset($_GET['customer'])) {
    foreach ($customers as $c) {
        $myfile = fopen("Emails/Custom.html", "w");
        $txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  text-align: right; " >' . $_GET["emailcontent"] . ' <br/></div>
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
        $mail->addAddress($c->Email);


        $mail->Subject = $_SERVER['HTTP_HOST'] . ' - خبرنامه';
        $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            $_SESSION[SESSION_BOOL_CUSTOMER_EMAIL_SENT] = false;
//            header('location:Feeds.php');
        } else {
            $_SESSION[SESSION_BOOL_CUSTOMER_EMAIL_SENT] = true;
//            header('location:Feeds.php');
        }
    }
}

header('location:Feeds.php');

