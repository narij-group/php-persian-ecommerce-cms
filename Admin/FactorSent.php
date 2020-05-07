<meta charset="UTF-8">
<?php

//TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->EditFactorProduct != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SMSDataSource.inc';

require 'Scripts/Mailer/PHPMailerAutoload.php';
require 'Scripts/Mailer/class.smtp.php';
require 'Scripts/Mailer/class.phpmailer.php';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();

$domain = $_SERVER['SERVER_NAME'];
$myfile = fopen("Emails/OrderStatus.html", "w");
$FactorProduct = new FactorProductDataSource();
$FactorProduct->open();
//$FactorProduct->TraceCode = $_GET['code'];
$records = $FactorProduct->FillByCode($_GET['code']);
//$FactorProduct->close();

if ($_GET['status'] == 1) {
    foreach ($records as $fp) {
        if ($fp->Status != 1) {
            if ($fp->Status == 3) {
                require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";
                $pr = new ProductColorDataSource();
                $pr->open();
                $prs = $pr->GetProductColorsForOneProduct($fp->Product->ProductId);
//                $pr->close();
                foreach ($prs as $p) {
                    if ($p->Color->Name == $fp->Color) {
                        $p->Quantity = $p->Quantity - $fp->Count;
                        $pr->UpdateQuantity($p);
                    }
                }
                $pr->close();
            }
            $FactorProduct2 = $FactorProduct->FindOneFactorProductBasedOnId($fp->FactorProductId);
            $FactorProduct->Preparing($fp->FactorProductId);
            $txt = '
        <!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">    
</head>
<body style="direction: rtl;">
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " >سفارش شما با کد پیگیری <b>' . $FactorProduct2->TraceCode . '</b> تایید شده و در پروسه انبار قرار دارد.</div>
</body>
</html>
        ';
        }
    }
} elseif ($_GET['status'] == 2) {
    foreach ($records as $fp) {
        if ($fp->Status != 2) {
            if ($fp->Status == 3) {
                require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";
                $pr = new ProductColorDataSource();
                $pr->open();
                $prs = $pr->GetProductColorsForOneProduct($fp->Product->ProductId);
                foreach ($prs as $p) {
                    if ($p->Color->Name == $fp->Color) {
                        $p->Quantity = $p->Quantity - $fp->Count;
                        $pr->UpdateQuantity($p);
                    }
                }
                $pr->close();
            }

            $FactorProduct2 = $FactorProduct->FindOneFactorProductBasedOnId($fp->FactorProductId);
            $FactorProduct->Sent($fp->FactorProductId);
            $txt = '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " >سفارش شما با کد پیگیری <b>' . $FactorProduct2->TraceCode . '</b> ارسال شد و وارد مرحله پست شد. با تشکر</div>
</body>
</html>
        ';
        }
    }
} elseif ($_GET['status'] == 3) {
    if ($fp->Status != 3) {
        foreach ($records as $fp) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";
            $pr = new ProductColorDataSource();
            $pr->open();
            $prs = $pr->GetProductColorsForOneProduct($fp->Product->ProductId);
            foreach ($prs as $p) {
                if ($p->Color->Name == $fp->Color) {
                    $p->Quantity = $p->Quantity + $fp->Count;
                    $pr->UpdateQuantity($p);
                }
            }
            $pr->close();
            $FactorProduct2 = $FactorProduct->FindOneFactorProductBasedOnId($fp->FactorProductId);
            $FactorProduct->Canceled($fp->FactorProductId);
            $txt = '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="width: 100%;  height: 70px;  background-color: #f9f9f9;  line-height: 70px; " ><img style="height: 50px;  margin-top: 10px;  margin-left: 15px;  width: auto;  float: left; "  src="http://' . $domain . "/" . $settings->PLogo . '"/></div>
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " >متاسفانه سفارش شما با کد پیگیری <b>' . $FactorProduct2->TraceCode . '</b> لغو شده است می توانید با پشتیبانی تماس حاصل فرمایید.</div>
</body>
</html>
        ';
        }
    }
} else {
    $txt = "";
}
fwrite($myfile, $txt);
fclose($myfile);
if ($txt != "") {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = $settings->SMTP;
    $mail->SMTPAuth = true;
    $mail->Username = $settings->Email;
    $mail->Password = $settings->Password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $settings->SMTPPort;

    echo file_get_contents('Emails/OrderStatus.html');


    $mail->setFrom($settings->Email, $settings->Email);
    $mail->addAddress($FactorProduct2->Factor->Customer->Address);

    $mail->Subject = $_SERVER['HTTP_HOST'] . ' - وضعیت سفارش';
    $mail->msgHTML(file_get_contents('Emails/OrderStatus.html'), dirname(__FILE__));
    if ($settings->isEmail == 1) {
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

}

$sms = new SMSDataSource();
if (isset($_GET['status'])) {
    if ($_GET['status'] == 1) {
        $sms->message = urlencode("   - سفارش شما با کد پیگیری" . $FactorProduct2->TraceCode . " تایید شده و در پروسه انبار قرار دارد،" . " جهت اطلاعات بیشتر به سایت مراجعه کنید." . "\n" . $domain);
    } elseif ($_GET['status'] == 2) {
        $sms->message = urlencode("    - سفارش شما با کد پیگیری" . $FactorProduct2->TraceCode . " ارسال شد و تحویل پستچی داده شد. " . "\n" . $domain);
    } elseif ($_GET['status'] == 3) {
        $sms->message = urlencode(" - سفارش شما با کد پیگیری" . $FactorProduct2->TraceCode . " لغو شده است می توانید با پشتیبانی تماس حاصل فرمایید،" . " جهت اطلاعات بیشتر به سایت مراجعه کنید." . "\n" . $domain);
    }
}
$sms->recipientNumber = "'" . $FactorProduct2->Factor->Customer->Mobile . "'";
if ($settings->SMS == 1) {
    $sms->enqueueSample();
}
if (isset($_GET['code'])) {
    header('Location:FactorProducts.php?code=' . $_GET['code']);
} else {
    header('Location:FactorProducts.php');
}

