<?php


/**
 * Class Settings
 */
class Settings
{

    /**
     * @var int
     */
    public $SettingsId;
    /**
     * @var int
     */
    public $Currency;
    /**
     * @var int
     */
    public $FreeShipping;
    /**
     * @var string
     */
    public $Language;
    /**
     * @var string
     */
    public $Owner;
    /**
     * @var null
     */
    public $Coupon;
    /**
     * @var null
     */
    public $CouponExpire;
    /**
     * @var null
     */
    public $MaxCoupon;
    /**
     * @var string
     */
    public $Numbers;
    /**
     * @var string
     */
    public $Email;
    /**
     * @var string
     */
    public $Password;
    /**
     * @var string
     */
    public $SMTP;
    /**
     * @var int
     */
    public $SMTPPort;
    /**
     * @var string
     */
    public $Telegram;
    /**
     * @var string
     */
    public $Facebook;
    /**
     * @var string
     */
    public $Twitter;
    /**
     * @var string
     */
    public $ILogo;
    /**
     * @var string
     */
    public $PLogo;
    /**
     * @var string
     */
    public $Instagram;
    /**
     * @var string
     */
    public $AboutSite;
    /**
     * @var string
     */
    public $SiteName;
    /**
     * @var string
     */
    public $ENamadLink;
//    public $ENamadImage;
    /**
     * @var null
     */
    public $Tax;
    /**
     * @var string
     */
    public $MetaDescription;
    /**
     * @var string
     */
    public $MetaAuthor;
    /**
     * @var string
     */
    public $MetaKeywords;
    /**
     * @var int
     */
    public $SMS;
    /**
     * @var int
     */
    public $isEmail;
    /**
     * @var int
     */
    public $CreationDate;
    /**
     * @var int
     */
    public $MaxCouponPercentage;
    /**
     * @var string
     */
    public $MenuCustomButtonName;
    /**
     * @var string
     */
    public $MenuCustomButtonLink;
    /**
     * @var string
     */
    public $MenuCustomButtonImage;


    public $AskQuantityForAdding;

    /**
     * @return string
     */
    public function getAskQuantityForAdding()
    {
        return $this->AskQuantityForAdding;
    }

    /**
     * @param string $AskQuantityForAdding
     */
    public function setAskQuantityForAdding($AskQuantityForAdding)
    {
        $this->AskQuantityForAdding = $AskQuantityForAdding;
    }

    /**
     * Settings constructor.
     */
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
        $this->AskQuantityForAdding = 0;
    }

    /**
     * @return int
     */
    public function getSettingsId()
    {
        return $this->SettingsId;
    }

    /**
     * @param int $SettingsId
     */
    public function setSettingsId($SettingsId)
    {
        $this->SettingsId = $SettingsId;
    }

    /**
     * @return int
     */
    public function getCurrency()
    {
        return $this->Currency;
    }

    /**
     * @param int $Currency
     */
    public function setCurrency($Currency)
    {
        $this->Currency = $Currency;
    }

    /**
     * @return int
     */
    public function getFreeShipping()
    {
        return $this->FreeShipping;
    }

    /**
     * @param int $FreeShipping
     */
    public function setFreeShipping($FreeShipping)
    {
        $this->FreeShipping = $FreeShipping;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->Language;
    }

    /**
     * @param string $Language
     */
    public function setLanguage($Language)
    {
        $this->Language = $Language;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->Owner;
    }

    /**
     * @param string $Owner
     */
    public function setOwner($Owner)
    {
        $this->Owner = $Owner;
    }

    /**
     * @return null
     */
    public function getCoupon()
    {
        return $this->Coupon;
    }

    /**
     * @param null $Coupon
     */
    public function setCoupon($Coupon)
    {
        $this->Coupon = $Coupon;
    }

    /**
     * @return null
     */
    public function getCouponExpire()
    {
        return $this->CouponExpire;
    }

    /**
     * @param null $CouponExpire
     */
    public function setCouponExpire($CouponExpire)
    {
        $this->CouponExpire = $CouponExpire;
    }

    /**
     * @return null
     */
    public function getMaxCoupon()
    {
        return $this->MaxCoupon;
    }

    /**
     * @param null $MaxCoupon
     */
    public function setMaxCoupon($MaxCoupon)
    {
        $this->MaxCoupon = $MaxCoupon;
    }

    /**
     * @return string
     */
    public function getNumbers()
    {
        return $this->Numbers;
    }

    /**
     * @param string $Numbers
     */
    public function setNumbers($Numbers)
    {
        $this->Numbers = $Numbers;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @return string
     */
    public function getSMTP()
    {
        return $this->SMTP;
    }

    /**
     * @param string $SMTP
     */
    public function setSMTP($SMTP)
    {
        $this->SMTP = $SMTP;
    }

    /**
     * @return int
     */
    public function getSMTPPort()
    {
        return $this->SMTPPort;
    }

    /**
     * @param int $SMTPPort
     */
    public function setSMTPPort($SMTPPort)
    {
        $this->SMTPPort = $SMTPPort;
    }

    /**
     * @return string
     */
    public function getTelegram()
    {
        return $this->Telegram;
    }

    /**
     * @param string $Telegram
     */
    public function setTelegram($Telegram)
    {
        $this->Telegram = $Telegram;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->Facebook;
    }

    /**
     * @param string $Facebook
     */
    public function setFacebook($Facebook)
    {
        $this->Facebook = $Facebook;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->Twitter;
    }

    /**
     * @param string $Twitter
     */
    public function setTwitter($Twitter)
    {
        $this->Twitter = $Twitter;
    }

    /**
     * @return string
     */
    public function getILogo()
    {
        return $this->ILogo;
    }

    /**
     * @param string $ILogo
     */
    public function setILogo($ILogo)
    {
        $this->ILogo = $ILogo;
    }

    /**
     * @return string
     */
    public function getPLogo()
    {
        return $this->PLogo;
    }

    /**
     * @param string $PLogo
     */
    public function setPLogo($PLogo)
    {
        $this->PLogo = $PLogo;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->Instagram;
    }

    /**
     * @param string $Instagram
     */
    public function setInstagram($Instagram)
    {
        $this->Instagram = $Instagram;
    }

    /**
     * @return string
     */
    public function getAboutSite()
    {
        return $this->AboutSite;
    }

    /**
     * @param string $AboutSite
     */
    public function setAboutSite($AboutSite)
    {
        $this->AboutSite = $AboutSite;
    }

    /**
     * @return string
     */
    public function getSiteName()
    {
        return $this->SiteName;
    }

    /**
     * @param string $SiteName
     */
    public function setSiteName($SiteName)
    {
        $this->SiteName = $SiteName;
    }

    /**
     * @return string
     */
    public function getENamadLink()
    {
        return $this->ENamadLink;
    }

    /**
     * @param string $ENamadLink
     */
    public function setENamadLink($ENamadLink)
    {
        $this->ENamadLink = $ENamadLink;
    }

    /**
     * @return null
     */
    public function getTax()
    {
        return $this->Tax;
    }

    /**
     * @param null $Tax
     */
    public function setTax($Tax)
    {
        $this->Tax = $Tax;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->MetaDescription;
    }

    /**
     * @param string $MetaDescription
     */
    public function setMetaDescription($MetaDescription)
    {
        $this->MetaDescription = $MetaDescription;
    }

    /**
     * @return string
     */
    public function getMetaAuthor()
    {
        return $this->MetaAuthor;
    }

    /**
     * @param string $MetaAuthor
     */
    public function setMetaAuthor($MetaAuthor)
    {
        $this->MetaAuthor = $MetaAuthor;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->MetaKeywords;
    }

    /**
     * @param string $MetaKeywords
     */
    public function setMetaKeywords($MetaKeywords)
    {
        $this->MetaKeywords = $MetaKeywords;
    }

    /**
     * @return int
     */
    public function getSMS()
    {
        return $this->SMS;
    }

    /**
     * @param int $SMS
     */
    public function setSMS($SMS)
    {
        $this->SMS = $SMS;
    }

    /**
     * @return int
     */
    public function getIsEmail()
    {
        return $this->isEmail;
    }

    /**
     * @param int $isEmail
     */
    public function setIsEmail($isEmail)
    {
        $this->isEmail = $isEmail;
    }

    /**
     * @return int
     */
    public function getCreationDate()
    {
        return $this->CreationDate;
    }

    /**
     * @param int $CreationDate
     */
    public function setCreationDate($CreationDate)
    {
        $this->CreationDate = $CreationDate;
    }

    /**
     * @return int
     */
    public function getMaxCouponPercentage()
    {
        return $this->MaxCouponPercentage;
    }

    /**
     * @param int $MaxCouponPercentage
     */
    public function setMaxCouponPercentage($MaxCouponPercentage)
    {
        $this->MaxCouponPercentage = $MaxCouponPercentage;
    }

    /**
     * @return string
     */
    public function getMenuCustomButtonName()
    {
        return $this->MenuCustomButtonName;
    }

    /**
     * @param string $MenuCustomButtonName
     */
    public function setMenuCustomButtonName($MenuCustomButtonName)
    {
        $this->MenuCustomButtonName = $MenuCustomButtonName;
    }

    /**
     * @return string
     */
    public function getMenuCustomButtonLink()
    {
        return $this->MenuCustomButtonLink;
    }

    /**
     * @param string $MenuCustomButtonLink
     */
    public function setMenuCustomButtonLink($MenuCustomButtonLink)
    {
        $this->MenuCustomButtonLink = $MenuCustomButtonLink;
    }

    /**
     * @return string
     */
    public function getMenuCustomButtonImage()
    {
        return $this->MenuCustomButtonImage;
    }

    /**
     * @param string $MenuCustomButtonImage
     */
    public function setMenuCustomButtonImage($MenuCustomButtonImage)
    {
        $this->MenuCustomButtonImage = $MenuCustomButtonImage;
    }


}
