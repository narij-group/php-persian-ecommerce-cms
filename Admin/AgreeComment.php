<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$cmds = new CommentDataSource();
$cmds->open();
$c = $cmds->FindOneCommentBasedOnId($_GET["id"]);
$cmds->Activate($_GET["id"]);


$cuds = new CustomerDataSource();
$cuds->open();
$c2 = $cuds->FindOneCustomerBasedOnId($c->Customer->CustomerId);
$cuds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';

require_once 'Scripts/Mailer/PHPMailerAutoload.php';
require_once 'Scripts/Mailer/class.smtp.php';
require_once 'Scripts/Mailer/class.phpmailer.php';
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
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Tahoma; " ><i>"' . $c->Value . '"</i> <br /><br /> پرسش و پاسخ شما با موفقیت تایید شد!</div>
<br/>
<br/>
<a style="padding: 5px 10px; color:#fff; background-color:#09f; border-radius:50px; float:left;  width: auto;   font-size: 10pt;  text-align: center;  font-family: Tahoma; " href="http://' . $domain . '/Post.php?id=' . $c->ProductId . '">بازدید از صفحه</a>
</body>
</html>
        ';

fwrite($myfile, $txt);
fclose($myfile);

$mail2 = new PHPMailer;
$mail2->CharSet = 'UTF-8';
$mail2->isSMTP();
$mail2->Host = $settings->SMTP;
$mail2->SMTPAuth = true;
$mail2->Username = $settings->Email;
$mail2->Password = $settings->Password;
$mail2->SMTPSecure = 'tls';
$mail2->Port = $settings->SMTPPort;


$mail2->setFrom($settings->Email, $settings->Email);
$mail2->addAddress($c2->Email);

$mail2->Subject = $_SERVER['HTTP_HOST'] . ' - پرسش و پاسخ';
$mail2->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));


if ($settings->isEmail == 1) {
    if (!$mail2->send()) {
        echo "Mailer Error: " . $mail2->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}


//header('Location:Comments.php');
?>
