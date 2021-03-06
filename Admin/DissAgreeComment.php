<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
$comment = new CommentDataSource();
$comment->open();
$c = $comment->FindOneCommentBasedOnId($_GET["id"]);
$comment->DissActivate($c->CommentId);
$comment->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
$customer = new CustomerDataSource();
$customer->open();
$c2 = $customer->FindOneCustomerBasedOnId($c->Customer->CustomerId);
$customer->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';


require 'Scripts/Mailer/PHPMailerAutoload.php';
require 'Scripts/Mailer/class.smtp.php';
require 'Scripts/Mailer/class.phpmailer.php';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
$domain = $_SERVER['SERVER_NAME'];
$myfile = fopen("Emails/Custom.html", "w");
$txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " ><i>"' . $c->Value . '"</i> <br /><br /> متاسفانه پرسش و پاسخ شما به دلایلی رد شده است!</div>
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
$mail->addAddress($c2->Email);

$mail->Subject = $_SERVER['HTTP_HOST'] . ' - پرسش و پاسخ';
$mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

//header('Location:Comments.php');
?>
<script>
    window.top.close();
</script>