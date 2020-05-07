<?php

require_once 'DataAccess.inc';

class Settings
{

    public $SettingsId;
    public $Currency;
    public $FreeShipping;
    public $Language;
    public $Owner;
    public $Coupon;
    public $CouponExpire;
    public $MaxCoupon;
    public $Numbers;
    public $Email;
    public $Password;
    public $SMTP;
    public $SMTPPort;
    public $Telegram;
    public $Facebook;
    public $Twitter;
    public $ILogo;
    public $PLogo;
    public $Instagram;
    public $AboutSite;
    public $SiteName;
    public $ENamadLink;
//    public $ENamadImage;
    public $Tax;
    public $MetaDescription;
    public $MetaAuthor;
    public $MetaKeywords;
    public $SMS;
    public $isEmail;
    public $CreationDate;
    public $MaxCouponPercentage;
    public $MenuCustomButtonName;
    public $MenuCustomButtonLink;
    public $MenuCustomButtonImage;

    public function __construct()
    {
        $this->SettingsId = 0;
        $this->Currency = 0;
        $this->FreeShipping = 0;
        $this->Language = "";
        $this->Owner = "";
        $this->Numbers = "";
        $this->Email = "";
        $this->Password = "";
        $this->SMTP = "";
        $this->SMTPPort = 0;
        $this->isEmail = 0;
        $this->MaxCouponPercentage = 0;
        $this->SMS = 0;
        $this->Instagram = "";
        $this->SiteName = "";
        $this->Facebook = "";
        $this->Twitter = "";
        $this->Telegram = "";
        $this->MetaAuthor = "";
        $this->MetaDescription = "";
        $this->MetaKeywords = "";
        $this->PLogo = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->ILogo = "جهت انتخاب تصویر اینجا را کلیک کنید...";
//        $this->ENamadImage = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->ENamadLink = "";
        $this->AboutSite = "";
        $this->Coupon = NULL;
        $this->CouponExpire = NULL;
        $this->MaxCoupon = NULL;
        $this->Tax = NULL;
        $this->CreationDate = 0;
        $this->MenuCustomButtonName = "";
        $this->MenuCustomButtonLink = "";
        $this->MenuCustomButtonImage = "جهت انتخاب تصویر اینجا را کلیک کنید...";
    }

    public function Update()
    {
        $SQL = "Update settings Set `Currency`=" . $this->Currency . ", MaxCouponPercentage=" . $this->MaxCouponPercentage . ", SiteName='" . $this->SiteName . "',`CreationDate`=" . $this->CreationDate . ",`FreeShipping`=" . $this->FreeShipping . " , `Language`='" . $this->Language . "' , MetaAuthor='" . $this->MetaAuthor . "', MetaKeywords='" . $this->MetaKeywords . "', MetaDescription='" . $this->MetaDescription . "', Password='" . $this->Password . "', `SMTP`='" . $this->SMTP . "', `SMS`=" . $this->SMS . ", `isEmail`=" . $this->isEmail . ", `SMTPPort`=" . $this->SMTPPort . " , `Owner` = '" . $this->Owner . "' , `Numbers` = '" . $this->Numbers . "' , `Email` = '" . $this->Email . "' , `Telegram` = '" . $this->Telegram . "' , `Instagram` = '" . $this->Instagram . "' , `Facebook` = '" . $this->Facebook . "' , `Twitter` = '" . $this->Twitter . "' , `ILogo` = '" . $this->ILogo . "' , `PLogo` = '" . $this->PLogo . "', AboutSite = '" . $this->AboutSite . "', ENamadLink = '" . $this->ENamadLink . "', Coupon= " . $this->Coupon . ", MaxCoupon= " . $this->MaxCoupon . " , CouponExpire= " . $this->CouponExpire . " , Tax= " . $this->Tax . " , MenuCustomButtonName= '" . $this->MenuCustomButtonName . "', MenuCustomButtonLink= '" . $this->MenuCustomButtonLink . "', MenuCustomButtonImage= '" . $this->MenuCustomButtonImage . "' Where SettingsId = 1";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from settings ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $setting = new Settings();
            $setting->SettingsId = $row['SettingsId'];
            $setting->Currency = $row['Currency'];
            $setting->FreeShipping = $row['FreeShipping'];
            $setting->Language = $row['Language'];
            $setting->Owner = $row['Owner'];
            $setting->AboutSite = $row['AboutSite'];
            $setting->Coupon = $row['Coupon'];
            $setting->MaxCoupon = $row['MaxCoupon'];
            $setting->CouponExpire = $row['CouponExpire'];
            $setting->SiteName = $row['SiteName'];
            $setting->CreationDate = $row['CreationDate'];
            $setting->Numbers = $row['Numbers'];
            $setting->Email = $row['Email'];
            $setting->Password = $row['Password'];
            $setting->SMTP = $row['SMTP'];
            $setting->SMTPPort = $row['SMTPPort'];
            $setting->ENamadLink = $row['ENamadLink'];
            $setting->MaxCouponPercentage = $row['MaxCouponPercentage'];
            $setting->Instagram = $row['Instagram'];
            $setting->Facebook = $row['Facebook'];
            $setting->ILogo = $row['ILogo'];
            $setting->PLogo = $row['PLogo'];
            $setting->Twitter = $row['Twitter'];
            $setting->Telegram = $row['Telegram'];
            $setting->Tax = $row['Tax'];
            $setting->MetaDescription = $row['MetaDescription'];
            $setting->MetaAuthor = $row['MetaAuthor'];
            $setting->MetaKeywords = $row['MetaKeywords'];
            $setting->SMS = $row['SMS'];
            $setting->isEmail = $row['isEmail'];
            $setting->MenuCustomButtonImage = $row['MenuCustomButtonImage'];
            $setting->MenuCustomButtonName = $row['MenuCustomButtonName'];
            $setting->MenuCustomButtonLink = $row['MenuCustomButtonLink'];
        }
        return $setting;
    }

}
