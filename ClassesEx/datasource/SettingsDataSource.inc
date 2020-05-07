<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Settings.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SettingsDataSource
{

    public $da;

    function __construct()
    {
        $this->da = new DataAccessEx();
    }

    public function open()
    {
        $this->da->open();
    }

    public function close()
    {
        $this->da->close();
    }


    public function Update(Settings $settings)
    {
        $SQL = "Update settings Set `Currency`=" . $settings->Currency . ", MaxCouponPercentage=" . $settings->MaxCouponPercentage . ", SiteName='" . $settings->SiteName . "',`CreationDate`=" . $settings->CreationDate . ",`FreeShipping`=" . $settings->FreeShipping . " , `Language`='" . $settings->Language . "' , MetaAuthor='" . $settings->MetaAuthor . "', MetaKeywords='" . $settings->MetaKeywords . "', MetaDescription='" . $settings->MetaDescription . "', Password='" . $settings->Password . "', `SMTP`='" . $settings->SMTP . "', `SMS`=" . $settings->SMS . ", `isEmail`=" . $settings->isEmail . ", `SMTPPort`=" . $settings->SMTPPort . " , `Owner` = '" . $settings->Owner . "' , `Numbers` = '" . $settings->Numbers . "' , `Email` = '" . $settings->Email . "' , `Telegram` = '" . $settings->Telegram . "' , `Instagram` = '" . $settings->Instagram . "' , `Facebook` = '" . $settings->Facebook . "' , `Twitter` = '" . $settings->Twitter . "' , `ILogo` = '" . $settings->ILogo . "' , `PLogo` = '" . $settings->PLogo . "', AboutSite = '" . $settings->AboutSite . "', ENamadLink = '" . $settings->ENamadLink . "', Coupon= " . $settings->Coupon . ", MaxCoupon= " . $settings->MaxCoupon . " , CouponExpire= " . $settings->CouponExpire . " , Tax= " . $settings->Tax . " , MenuCustomButtonName= '" . $settings->MenuCustomButtonName . "', MenuCustomButtonLink= '" . $settings->MenuCustomButtonLink . "', MenuCustomButtonImage= '" . $settings->MenuCustomButtonImage . "', AskQuantityForAdding= " . $settings->AskQuantityForAdding . " Where SettingsId = 1";
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from settings ";
        $results = $this->da->execSelect($SQL);
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
            $setting->AskQuantityForAdding = $row['AskQuantityForAdding'];
//            echo $setting->AskQuantityForAdding;
        }
        return $setting;
    }

}
