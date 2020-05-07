<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
$productcolor = new ProductColor();
if ($_POST['quantity'] != "" && $_POST['color'] != NULL) {
    $color = new ProductColorDataSource();
    $color->open();
    $productcolor2 = $color->FindColor($_POST['product'], $_POST['color']);
    $color->close();
    if ($productcolor2 == null) {
        $productcolor->Product = $_POST['product'];
        $productcolor->Color = $_POST['color'];
        $productcolor->Quantity = $_POST['quantity'];

        $pcds = new ProductColorDataSource();
        $pcds->open();
        $pcds->Insert($productcolor);
        $pcds->close();
    } else {

        $pcds = new ProductColorDataSource();
        $pcds->open();
        $productcolor2->Quantity = $_POST['quantity'];
        $pcds->Update($productcolor2);
        $pcds->close();

    }

    $pcds = new ProductColorDataSource();
    $pcds->open();
    $pcolors = $pcds->GetProductColorsForOneProduct($_POST['product']);
    $pcds->close();

    foreach ($pcolors as $p) {
        echo "<div class = 'colorSample' style = 'border:3px solid " . $p->Color->Sample . ";' title = '" . $p->Color->Name . "'>" . $p->Quantity . "<a class='dltbtn2'><i class='fa fa-trash-o'></i>$p->ProductColorId</a></div>";
    }
} else {

    $pcds = new ProductColorDataSource();
    $pcds->open();

    echo "<div class='alert alert-warning'>رنگ و تعداد موجودی را پر کنید!</div><br />";
    $pcolors = $pcds->GetProductColorsForOneProduct($_POST['product']);
    $pcds->close();
    foreach ($pcolors as $p) {
        echo "<div class = 'colorSample' style = 'border:3px solid " . $p->Color->Sample . ";' title = '" . $p->Color->Name . "'>" . $p->Quantity . "<a class='dltbtn2'><i class='fa fa-trash-o'></i>$p->ProductColorId</a></div>";
    }
}
?>
<script>
    $(document).ready(function () {
        $(".dltbtn2").click(function () {
            if (confirm('آیا میخواهید این رنگ را حذف نمایید ؟')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxDeleteColor.php',
                    data: {colorId: $(this).text(), product:<?php echo $_POST['product']; ?>},
                    success: function (data) {
                        $('#colorSamples').html(data);
                    }
                });
            }
        });
    });
</script>

<?php

if (isset($_POST['editmode'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    $customer = new CustomerDataSource();
    $customer->open();
    $customers = $customer->Fill();
    $customer->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
    $product = new ProductDataSource();
    $product->open();
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

    $customer = new CustomerDataSource();
    $customer->open();
    foreach ($customers as $c) {
        if (strpos($c->RequestedProducts, $_POST['product']) != false) {
            $mail->addAddress($c->Email);
            $c->RequestedProducts = str_replace(',' . $_POST['product'], '', $c->RequestedProducts);
            $customer->UpdateRequests($c);
            $send = true;
        }
    }
    $customer->close();

    $mail->Subject = $_SERVER['HTTP_HOST'] . ' - موجودی محصول';
    $mail->msgHTML(file_get_contents('Emails/Custom.html'), dirname(__FILE__));
    if ($send == true) {
        if (!$mail->send()) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
//    echo "Message sent!";
        }

    }
}

