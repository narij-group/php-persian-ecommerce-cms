<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';


$comment2 = new Comment();

$comment = new CommentDataSource();
$comment->open();
$c = $comment->FindOneCommentBasedOnId($_GET["id"]);
$commentreply = false;
//$comment ->close();

$customer = new CustomerDataSource();
$customer->open();
if ($c->ReplyId != 0) {

    $c3 = $comment->FindOneCommentBasedOnId($c->ReplyId);
    $c5 = $customer->FindOneCustomerBasedOnId($c3->Customer->CustomerId);
    $commentreply = true;
}

$c2 = $customer->FindOneCustomerBasedOnId($c->Customer->CustomerId);
$customer->close();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';

require_once 'Scripts/Mailer/PHPMailerAutoload.php';
require_once 'Scripts/Mailer/class.smtp.php';
require_once 'Scripts/Mailer/class.phpmailer.php';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
$domain = $_SERVER['SERVER_NAME'];
if ($commentreply == true) {

    $myfile = fopen("Emails/Custom.html", "w");

    $txt = '
<!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Tahoma; " ><i>"' . $c->Value . '"</i> <br /><br />' . $c2->Name . ' ' . $c2->Family . ' به پرسش شما پاسخ داده است.</div>
<br/>
<br/>
<a style="padding: 5px 10px; color:#fff; background-color:#09f; border-radius:50px; float:left;  width: auto;   font-size: 10pt;  text-align: center;  font-family: Tahoma; " href="http://' . $domain . '/Post.php?id=' . $c->ProductId . '">بازدید از صفحه</a>
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
    $mail->addAddress($c5->Email);

    $mail->Subject = $_SERVER['HTTP_HOST'] . ' - پرسش و پاسخ';
    $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));


    if ($settings->isEmail == 1) {
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}
