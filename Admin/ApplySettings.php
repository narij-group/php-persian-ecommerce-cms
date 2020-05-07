<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';


$setting = new Settings();

$setting->SettingsId = 1;
if (isset($_POST['language']) == false) {
    $setting->Language = "EN";
} else {
    $setting->Language = "FA";
}
if (isset($_POST['currency']) == false) {
    $setting->Currency = 1;
} else {
    $setting->Currency = 10;
}

if (trim($_POST['coupon']) == "") {
    $setting->Coupon = 0;
} else {
    $_POST['coupon'] = str_replace(',', '', $_POST['coupon']);
    $setting->Coupon = $_POST['coupon'];
}
if (trim($_POST['maxpercent']) == "") {
    $setting->MaxCouponPercentage = 0;
} else {
    $_POST['maxpercent'] = str_replace(',', '', $_POST['maxpercent']);
    $setting->MaxCouponPercentage = $_POST['maxpercent'];
}

if (trim($_POST['tax']) == "") {
    $setting->Tax = 0;
} else {
    $setting->Tax = $_POST['tax'];
}

if (trim($_POST['maxcoupon']) == "") {
    $setting->MaxCoupon = 0;
} else {
    $setting->MaxCoupon = $_POST['maxcoupon'];
}

if (trim($_POST['couponexpire']) == "") {
    $setting->CouponExpire = 0;
} else {
    $setting->CouponExpire = $_POST['couponexpire'];
}

if (isset($_POST['isEmail'])) {
    $setting->isEmail = 1;
} else {
    $setting->isEmail = 0;
}

if (isset($_POST['AskQuantityForAdding'])) {
    $setting->AskQuantityForAdding = 1;
} else {
    $setting->AskQuantityForAdding = 0;
}

if (isset($_POST['SMS'])) {
    $setting->SMS = 1;
} else {
    $setting->SMS = 0;
}

if (trim($_POST['numbers']) == "") {
    $setting->Numbers = "";
} else {
    $setting->Numbers = $_POST['numbers'];
}
if (trim($_POST['email']) == "") {
    $setting->Email = "";
} else {
    $setting->Email = $_POST['email'];
}
if (trim($_POST['metad']) == "") {
    $setting->MetaDescription = "";
} else {
    $setting->MetaDescription = $_POST['metad'];
}
if (trim($_POST['metaa']) == "") {
    $setting->MetaAuthor = "";
} else {
    $setting->MetaAuthor = $_POST['metaa'];
}
if (trim($_POST['metak']) == "") {
    $setting->MetaKeywords = "";
} else {
    $setting->MetaKeywords = $_POST['metak'];
}
if (trim($_POST['password']) == "") {
    $setting->Password = "";
} else {
    $setting->Password = $_POST['password'];
}
if (trim($_POST['smtp']) == "") {
    $setting->SMTP = "";
} else {
    $setting->SMTP = $_POST['smtp'];
}
if (trim($_POST['smtpport']) == "") {
    $setting->SMTPPort = "";
} else {
    $setting->SMTPPort = $_POST['smtpport'];
}
if (trim($_POST['telegram']) == "") {
    $setting->Telegram = "#";
} else {
    $setting->Telegram = $_POST['telegram'];
}
if (trim($_POST['instagram']) == "") {
    $setting->Instagram = "#";
} else {
    $setting->Instagram = $_POST['instagram'];
}
if (trim($_POST['facebook']) == "") {
    $setting->Facebook = "#";
} else {
    $setting->Facebook = $_POST['facebook'];
}
if (trim($_POST['twitter']) == "") {
    $setting->Twitter = "#";
} else {
    $setting->Twitter = $_POST['twitter'];
}
if (trim($_POST['aboutSite']) == "") {
    $setting->AboutSite = "";
} else {
    $setting->AboutSite = $_POST['aboutSite'];
}
if (trim($_POST['enamadlink']) == "") {
    $setting->ENamadLink = "";
} else {
    $setting->ENamadLink = $_POST['enamadlink'];
}
if (trim($_POST['plogo']) == "") {
    $setting->PLogo = "";
} else {
    $s = str_replace("/DigitalShopV1//", "", $_POST['plogo']);
    $s2 = str_replace("/DigitalShopV1/", "", $s);
    $setting->PLogo = str_replace("//", "/", $s2);
}
if (trim($_POST['ilogo']) == "") {
    $setting->ILogo = "";
} else {
    $s = str_replace("/DigitalShopV1//", "", $_POST['ilogo']);
    $s2 = str_replace("/DigitalShopV1/", "", $s);
    $setting->ILogo = str_replace("//", "/", $s2);
}

if (trim($_POST['custombtnimage']) == "") {
    $setting->MenuCustomButtonImage = "";
} else {
    $s = str_replace("/DigitalShopV1//", "", $_POST['custombtnimage']);
    $s2 = str_replace("/DigitalShopV1/", "", $s);
    $setting->MenuCustomButtonImage = str_replace("//", "/", $s2);
}
$setting->MenuCustomButtonName = $_POST['custombtnname'];
$setting->MenuCustomButtonLink = $_POST['custombtnlink'];


$setting->Owner = $_POST['owner'];
$setting->SiteName = $_POST['sitename'];
if (trim($_POST['cdate']) == "") {
    $setting->CreationDate = 0;
} else {
    $setting->CreationDate = $_POST['cdate'];
}
if (trim($_POST['freeshipping']) == "") {
    $setting->FreeShipping = 0;
} else {
    $setting->FreeShipping = $_POST['freeshipping'];
}

$sds = new SettingsDataSource();
$sds->open();
$sds->Update($setting);
$sds->close();
header('Location:Index.php');
