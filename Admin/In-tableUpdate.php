<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
if (isset($_POST['color']) && isset($_POST['quantity']) && isset($_POST['quantityContent']) && isset($_POST['quantityId'])) {
    $_POST['product'] = str_replace('quantity', '', $_POST['quantityId']);
    ?>
    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
    <?php
    require_once 'Template/top2.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
    $productcolor = new ProductColor();
    $color = new ProductColorDataSource();
    $color->open();
    $productcolor2 = $color->FindColor($_POST['product'], $_POST['color']);

    if ($productcolor2 == null) {
        $productcolor->Product = $_POST['product'];
        $productcolor->Color = $_POST['color'];
        $productcolor->Quantity = $_POST['quantity'];
        $color->Insert($productcolor);
    } else {
        $productcolor2->Quantity = $_POST['quantity'];
        $color->Update($productcolor2);
    }

    $color->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    $customer = new CustomerDataSource();
    $customer->open();
    $customers = $customer->Fill();
    $customer->close();
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
    $product = new ProductDataSource();
    $product->open();
//    $product->ProductId = $_POST['product'];
    $p = $product->FindOneProductBasedOnId($_POST['product']);
    $product->close();
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
<div style="padding: 20px;  width: auto;  font-size: 11pt;  text-align: right;  font-family: Arial; " > محصول <b>' . $p->Name . '</b>  ' . 'موجود شده است جهت خرید به لینک زیر مراجعه کنید :' . '<br/><br/> <a href="http://' . $domain . '/Post.php?id=' . $p->ProductId . '" >مشاهده محصول</a></div>
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

    $send = false;
    $mail->setFrom($settings->Email, $settings->Email);
    $cds = new CustomerDataSource();
    $cds->open();

    foreach ($customers as $c) {
        if (strpos($c->RequestedProducts, $_POST['product']) != false) {
            $mail->addAddress($c->Email);
            $c->RequestedProducts = str_replace(',' . $_POST['product'], '', $c->RequestedProducts);
            $cds->UpdateRequests($c);
            $send = true;
        }
    }
    $cds->close();
    $mail->Subject = $_SERVER['HTTP_HOST'] . ' - موجودی محصول';
    $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));
    if ($send == true) {
        if (!$mail->send()) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
//    echo "Message sent!";
        }

    }
} elseif (isset($_POST['price']) && isset($_POST['priceId'])) {
    require_once 'Template/top2.php';
    $_POST['productId'] = str_replace("price", '', $_POST['priceId']);
    echo $_POST['productId'];
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
    $price = new Price();
    $price->Date = date("Y/m/d");
    $price->Product = $_POST['productId'];
    $price->User = $user1->UserId;
    $_POST['price'] = str_replace(',', '', $_POST['price']);
    $pds = new  PriceDataSource();
    $pds->open();
    $lastPrice = $pds->GetLastPriceForOneProduct($_POST['productId']);

    $price->Value = $_POST['price'];
    if ($lastPrice != $_POST['price']) {
        $pds->Insert($price);
    }
    $pds->close();
}
