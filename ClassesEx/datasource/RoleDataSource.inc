<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Role.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class RoleDataSource
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


    public function Insert(Role $role)
    {
        $SQL = "Insert Into roles(Name,News,InsertNews,EditNews,DeleteNews,NewsApprove,ProductApprove,Products,InsertProduct,EditProduct,DeleteProduct,ProductGroupLimit,BrandLimit,AllowedProductGroups,AllowedProductSubGroups,AllowedProductSupperGroups,AllowedBrands,UserCoupons,InsertUserCoupon,EditUserCoupon,DeleteUserCoupon,LinkBoxes,InsertLinkBox,EditLinkBox,DeleteLinkBox,Users,InsertUser,EditUser,DeleteUser,Slides,InsertSlide,EditSlide,DeleteSlide,ProductCoupons,InsertProductCoupon,EditProductCoupon,DeleteProductCoupon,Thumbs,InsertThumb,EditThumb,DeleteThumb,FactorProducts,EditFactorProduct,Orders,EditOrder,Panels,EditPanel,Prices,InsertPrice,EditPrice,DeletePrice,PriceChange,ShippingMethods,InsertShippingMethod,EditShippingMethod,DeleteShippingMethod,Shippings,InsertShipping,EditShipping,DeleteShipping,Comments,EditComment,DeleteComment,Discounts,EditDiscount,DeleteDiscount,Brands,InsertBrand,EditBrand,DeleteBrand,Customers,InsertCustomer,EditCustomer,DeleteCustomer,ProductProperties,InsertProductProperty,EditProductProperty,DeleteProductProperty,ProductPropertySubGroupLimit,AllowedProductPropertySubGroups,PaymentMethods,EditPaymentMethod,Opinions,EditOpinion,DeleteOpinion,Feeds,InsertFeed,EditFeed,DeleteFeed,FeedSendEmail,Guarantees,InsertGuarantee,EditGuarantee,DeleteGuarantee,Colors,InsertColor,EditColor,DeleteColor,Services,InsertService,EditService,DeleteService,Groups,InsertGroup,EditGroup,DeleteGroup,SubGroups,InsertSubGroup,EditSubGroup,DeleteSubGroup,SupperGroups,InsertSupperGroup,EditSupperGroup,DeleteSupperGroup,Roles,InsertRole,EditRole,DeleteRole,Stats,Settings,MenuSettings,ColorSettings,LinkBoxGroup,SendSMS,SpecialOffers,InsertSpecialOffer,EditSpecialOffer,DeleteSpecialOffer) Values ('" . $role->Name . "' , " . $role->News . ", " . $role->InsertNews . ", " . $role->EditNews . ", " . $role->DeleteNews . ", " . $role->NewsApprove . ", " . $role->ProductApprove . ", " . $role->Products . ", " . $role->InsertProduct . ", " . $role->EditProduct . ", " . $role->DeleteProduct . ", " . $role->ProductGroupLimit . ", " . $role->BrandLimit . ", '" . $role->AllowedProductGroups . "', '" . $role->AllowedProductSubGroups . "', '" . $role->AllowedProductSupperGroups . "', '" . $role->AllowedBrands  . "', " . $role->UserCoupons . ", " . $role->InsertUserCoupon . ", " . $role->EditUserCoupon . ", " . $role->DeleteUserCoupon . ", " . $role->LinkBoxes . ", " . $role->InsertLinkBox . ", " . $role->EditLinkBox . ", " . $role->DeleteLinkBox . ", " . $role->Users . ", " . $role->InsertUser . ", " . $role->EditUser . ", " . $role->DeleteUser . ", " . $role->Slides . ", " . $role->InsertSlide . ", " . $role->EditSlide . ", " . $role->DeleteSlide . ", " . $role->ProductCoupons . ", " . $role->InsertProductCoupon . ", " . $role->EditProductCoupon . ", " . $role->DeleteProductCoupon . ", " . $role->Thumbs . ", " . $role->InsertThumb . ", " . $role->EditThumb . ", " . $role->DeleteThumb . ", " . $role->FactorProducts . ", " . $role->EditFactorProduct . ", " . $role->Orders . ", " . $role->EditOrder . ", " . $role->Panels . ", " . $role->EditPanel . ", " . $role->Prices . ", " . $role->InsertPrice . ", " . $role->EditPrice . ", " . $role->DeletePrice . ", " . $role->PriceChange . ", " . $role->ShippingMethods . ", " . $role->InsertShippingMethod . ", " . $role->EditShippingMethod . ", " . $role->DeleteShippingMethod . ", " . $role->Shippings . ", " . $role->InsertShipping . ", " . $role->EditShipping . ", " . $role->DeleteShipping . ", " . $role->Comments . " , " . $role->EditComment . ", " . $role->DeleteComment . ", " . $role->Discounts . ", " . $role->EditDiscount . ", " . $role->DeleteDiscount . ", " . $role->Brands . ", " . $role->InsertBrand . ", " . $role->EditBrand . ", " . $role->DeleteBrand . ", " . $role->Customers . ", " . $role->InsertCustomer . ", " . $role->EditCustomer . ", " . $role->DeleteCustomer . ", " . $role->ProductProperties . ", " . $role->InsertProductProperty . ", " . $role->EditProductProperty . ", " . $role->DeleteProductProperty . ", " . $role->ProductPropertySubGroupLimit . ", '" . $role->AllowedProductPropertySubGroups . "', " . $role->PaymentMethods . ", " . $role->EditPaymentMethod . ", " . $role->Opinions . ", " . $role->EditOpinion . ", " . $role->DeleteOpinion . ", " . $role->Feeds . ", " . $role->InsertFeed . ", " . $role->EditFeed . ", " . $role->DeleteFeed . ", " . $role->FeedSendEmail . ", " . $role->Guarantees . ", " . $role->InsertGuarantee . ", " . $role->EditGuarantee . ", " . $role->DeleteGuarantee . ", " . $role->Colors . ", " . $role->InsertColor . ", " . $role->EditColor . ", " . $role->DeleteColor . ", " . $role->Services . ", " . $role->InsertService . ", " . $role->EditService . ", " . $role->DeleteService . ", " . $role->Groups . ", " . $role->InsertGroup . ", " . $role->EditGroup . ", " . $role->DeleteGroup . ", " . $role->SubGroups . ", " . $role->InsertSubGroup . ", " . $role->EditSubGroup . ", " . $role->DeleteSubGroup . ", " . $role->SupperGroups . ", " . $role->InsertSupperGroup . ", " . $role->EditSupperGroup . ", " . $role->DeleteSupperGroup . ", " . $role->Roles . ", " . $role->InsertRole . ", " . $role->EditRole . ", " . $role->DeleteRole . ", " . $role->Stats . ", " . $role->Settings . ", " . $role->MenuSettings . ", " . $role->ColorSettings . ", " . $role->LinkBoxGroup . ", " . $role->SendSMS . " , " . $role->SpecialOffers . ", " . $role->InsertSpecialOffer . ", " . $role->EditSpecialOffer . ", " . $role->DeleteSpecialOffer . ")";
        $this->da->exec($SQL);
    }

    public function Update(Role $role)
    {
        $SQL = "Update roles Set `Name`='" . $role->Name . "',News=" . $role->News . ",EditNews=" . $role->EditNews . ",DeleteNews=" . $role->DeleteNews . ",InsertNews=" . $role->InsertNews . ",NewsApprove=" . $role->NewsApprove . ",ProductApprove=" . $role->ProductApprove . ",Products=" . $role->Products . ",EditProduct=" . $role->EditProduct . ",DeleteProduct=" . $role->DeleteProduct . ",ProductGroupLimit=" . $role->ProductGroupLimit . ",BrandLimit=" . $role->BrandLimit . ",InsertProduct=" . $role->InsertProduct . ",AllowedProductGroups='" . $role->AllowedProductGroups . "',AllowedProductSubGroups='" . $role->AllowedProductSubGroups . "',AllowedProductSupperGroups='" . $role->AllowedProductSupperGroups . "',AllowedBrands='" . $role->AllowedBrands . "' ,`UserCoupons`=" . $role->UserCoupons . ",`InsertUserCoupon`=" . $role->InsertUserCoupon . ",`EditUserCoupon`=" . $role->EditUserCoupon . ",`DeleteUserCoupon`=" . $role->DeleteUserCoupon . ",`LinkBoxes`=" . $role->LinkBoxes . ",`InsertLinkBox`=" . $role->InsertLinkBox . ",`EditLinkBox`=" . $role->EditLinkBox . ",`DeleteLinkBox`=" . $role->DeleteLinkBox . ",`LinkBoxGroup`=" . $role->LinkBoxGroup . ",`Users`=" . $role->Users . ",`InsertUser`=" . $role->InsertUser . ",`EditUser`=" . $role->EditUser . ",`DeleteUser`=" . $role->DeleteUser . ",`Slides`=" . $role->Slides . ",`InsertSlide`=" . $role->InsertSlide . ",`EditSlide`=" . $role->EditSlide . ",`DeleteSlide`=" . $role->DeleteSlide . ",`ProductCoupons`=" . $role->ProductCoupons . ",`InsertProductCoupon`=" . $role->InsertProductCoupon . ",`EditProductCoupon`=" . $role->EditProductCoupon . ",`DeleteProductCoupon`=" . $role->DeleteProductCoupon . ",`Thumbs`=" . $role->Thumbs . ",`InsertThumb`=" . $role->InsertThumb . ",`EditThumb`=" . $role->EditThumb . ",`DeleteThumb`=" . $role->DeleteThumb . ",`FactorProducts`=" . $role->FactorProducts . ",`EditFactorProduct`=" . $role->EditFactorProduct . ",`Orders`=" . $role->Orders . ",`EditOrder`=" . $role->EditOrder . ",`Panels`=" . $role->Panels . ",`EditPanel`=" . $role->EditPanel . ",`Prices`=" . $role->Prices . ",`InsertPrice`=" . $role->InsertPrice . ",`EditPrice`=" . $role->EditPrice . ",`DeletePrice`=" . $role->DeletePrice . ",`PriceChange`=" . $role->PriceChange . ",`ShippingMethods`=" . $role->ShippingMethods . ",`InsertShippingMethod`=" . $role->InsertShippingMethod . ",`EditShippingMethod`=" . $role->EditShippingMethod . ",`DeleteShippingMethod`=" . $role->DeleteShippingMethod . ",`Shippings`=" . $role->Shippings . ",`InsertShipping`=" . $role->InsertShipping . ",`EditShipping`=" . $role->EditShipping . ",`DeleteShipping`=" . $role->DeleteShipping . ",`Comments`=" . $role->Comments . ",`EditComment`=" . $role->EditComment . ",`DeleteComment`=" . $role->DeleteComment . ",`Discounts`=" . $role->Discounts . ",`EditDiscount`=" . $role->EditDiscount . ",`DeleteDiscount`=" . $role->DeleteDiscount . ",`Brands`=" . $role->Brands . ",`InsertBrand`=" . $role->InsertBrand . ",`EditBrand`=" . $role->EditBrand . ",`DeleteBrand`=" . $role->DeleteBrand . ",`Customers`=" . $role->Customers . ",`InsertCustomer`=" . $role->InsertCustomer . ",`EditCustomer`=" . $role->EditCustomer . ",`DeleteCustomer`=" . $role->DeleteCustomer . ",`ProductProperties`=" . $role->ProductProperties . ",`InsertProductProperty`=" . $role->InsertProductProperty . ",`EditProductProperty`=" . $role->EditProductProperty . ",`DeleteProductProperty`=" . $role->DeleteProductProperty . ",`ProductPropertySubGroupLimit`=" . $role->ProductPropertySubGroupLimit . ",`AllowedProductPropertySubGroups`='" . $role->AllowedProductPropertySubGroups . "',`PaymentMethods`=" . $role->PaymentMethods . ",`EditPaymentMethod`=" . $role->EditPaymentMethod . ",`Opinions`=" . $role->Opinions . ",`EditOpinion`=" . $role->EditOpinion . ",`DeleteOpinion`=" . $role->DeleteOpinion . ",`Feeds`=" . $role->Feeds . ",`InsertFeed`=" . $role->InsertFeed . ",`EditFeed`=" . $role->EditFeed . ",`DeleteFeed`=" . $role->DeleteFeed . ",`FeedSendEmail`=" . $role->FeedSendEmail . ",`Guarantees`=" . $role->Guarantees . ",`InsertGuarantee`=" . $role->InsertGuarantee . ",`EditGuarantee`=" . $role->EditGuarantee . ",`DeleteGuarantee`=" . $role->DeleteGuarantee . ",`Colors`=" . $role->Colors . ",`InsertColor`=" . $role->InsertColor . ",`EditColor`=" . $role->EditColor . ",`DeleteColor`=" . $role->DeleteColor . ",`Services`=" . $role->Services . ",`InsertService`=" . $role->InsertService . ",`EditService`=" . $role->EditService . ",`DeleteService`=" . $role->DeleteService . ",`Groups`=" . $role->Groups . ",`InsertGroup`=" . $role->InsertGroup . ",`EditGroup`=" . $role->EditGroup . ",`DeleteGroup`=" . $role->DeleteGroup . ",`SubGroups`=" . $role->SubGroups . ",`InsertSubGroup`=" . $role->InsertSubGroup . ",`EditSubGroup`=" . $role->EditSubGroup . ",`DeleteSubGroup`=" . $role->DeleteSubGroup . ",`SupperGroups`=" . $role->SupperGroups . ",`InsertSupperGroup`=" . $role->InsertSupperGroup . ",`EditSupperGroup`=" . $role->EditSupperGroup . ",`DeleteSupperGroup`=" . $role->DeleteSupperGroup . ",`Roles`=" . $role->Roles . ",`InsertRole`=" . $role->InsertRole . ",`EditRole`=" . $role->EditRole . ",`DeleteRole`=" . $role->DeleteRole . ",`Stats`=" . $role->Stats . ",`Settings`=" . $role->Settings . ",`ColorSettings`=" . $role->ColorSettings . ",`MenuSettings`=" . $role->MenuSettings . ",`SendSMS`=" . $role->SendSMS . ",`SpecialOffers`=" . $role->SpecialOffers . ",`InsertSpecialOffer`=" . $role->InsertSpecialOffer . ",`EditSpecialOffer`=" . $role->EditSpecialOffer . ",`DeleteSpecialOffer`=" . $role->DeleteSpecialOffer . " Where RoleId=" . $role->RoleId . "";
        $this->da->exec($SQL);
    }

    public function CustomUpdate(Role $role, $property, $value)
    {
        $SQL = "Update roles Set $property = '" . $value . "' Where RoleId=" . $role->RoleId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From roles Where RoleId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneRoleBasedOnId($id)
    {
        $SQL = "Select * From roles Where RoleId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $role = new Role();
            $role->RoleId = $row['RoleId'];
            $role->Name = $row['Name'];
            $role->News = $row['News'];
            $role->InsertNews = $row['InsertNews'];
            $role->EditNews = $row['EditNews'];
            $role->DeleteNews = $row['DeleteNews'];
            $role->NewsApprove = $row['NewsApprove'];
            $role->ProductApprove = $row['ProductApprove'];
            $role->Products = $row['Products'];
            $role->InsertProduct = $row['InsertProduct'];
            $role->EditProduct = $row['EditProduct'];
            $role->DeleteProduct = $row['DeleteProduct'];
            $role->ProductGroupLimit = $row['ProductGroupLimit'];
            $role->BrandLimit = $row['BrandLimit'];
            $role->AllowedProductGroups = $row['AllowedProductGroups'];
            $role->AllowedProductSubGroups = $row['AllowedProductSubGroups'];
            $role->AllowedProductSupperGroups = $row['AllowedProductSupperGroups'];
            $role->AllowedBrands = $row['AllowedBrands'];
            $role->UserCoupons = $row['UserCoupons'];
            $role->InsertUserCoupon = $row['InsertUserCoupon'];
            $role->EditUserCoupon = $row['EditUserCoupon'];
            $role->DeleteUserCoupon = $row['DeleteUserCoupon'];
            $role->LinkBoxes = $row['LinkBoxes'];
            $role->InsertLinkBox = $row['InsertLinkBox'];
            $role->EditLinkBox = $row['EditLinkBox'];
            $role->DeleteLinkBox = $row['DeleteLinkBox'];
            $role->LinkBoxGroup = $row['LinkBoxGroup'];
            $role->Users = $row['Users'];
            $role->InsertUser = $row['InsertUser'];
            $role->EditUser = $row['EditUser'];
            $role->DeleteUser = $row['DeleteUser'];
            $role->Slides = $row['Slides'];
            $role->InsertSlide = $row['InsertSlide'];
            $role->EditSlide = $row['EditSlide'];
            $role->DeleteSlide = $row['DeleteSlide'];
            $role->Thumbs = $row['Thumbs'];
            $role->InsertThumb = $row['InsertThumb'];
            $role->EditThumb = $row['EditThumb'];
            $role->DeleteThumb = $row['DeleteThumb'];
            $role->ProductCoupons = $row['ProductCoupons'];
            $role->InsertProductCoupon = $row['InsertProductCoupon'];
            $role->EditProductCoupon = $row['EditProductCoupon'];
            $role->DeleteProductCoupon = $row['DeleteProductCoupon'];
            $role->FactorProducts = $row['FactorProducts'];
            $role->EditFactorProduct = $row['EditFactorProduct'];
            $role->Orders = $row['Orders'];
            $role->EditOrder = $row['EditOrder'];
            $role->Panels = $row['Panels'];
            $role->EditPanel = $row['EditPanel'];
            $role->Prices = $row['Prices'];
            $role->InsertPrice = $row['InsertPrice'];
            $role->EditPrice = $row['EditPrice'];
            $role->DeletePrice = $row['DeletePrice'];
            $role->PriceChange = $row['PriceChange'];
            $role->ShippingMethods = $row['ShippingMethods'];
            $role->InsertShippingMethod = $row['InsertShippingMethod'];
            $role->EditShippingMethod = $row['EditShippingMethod'];
            $role->DeleteShippingMethod = $row['DeleteShippingMethod'];
            $role->Shippings = $row['Shippings'];
            $role->InsertShipping = $row['InsertShipping'];
            $role->EditShipping = $row['EditShipping'];
            $role->DeleteShipping = $row['DeleteShipping'];
            $role->Comments = $row['Comments'];
            $role->EditComment = $row['EditComment'];
            $role->DeleteComment = $row['DeleteComment'];
            $role->Discounts = $row['Discounts'];
            $role->EditDiscount = $row['EditDiscount'];
            $role->DeleteDiscount = $row['DeleteDiscount'];
            $role->Brands = $row['Brands'];
            $role->InsertBrand = $row['InsertBrand'];
            $role->EditBrand = $row['EditBrand'];
            $role->DeleteBrand = $row['DeleteBrand'];
            $role->Customers = $row['Customers'];
            $role->InsertCustomer = $row['InsertCustomer'];
            $role->EditCustomer = $row['EditCustomer'];
            $role->DeleteCustomer = $row['DeleteCustomer'];
            $role->ProductProperties = $row['ProductProperties'];
            $role->InsertProductProperty = $row['InsertProductProperty'];
            $role->EditProductProperty = $row['EditProductProperty'];
            $role->DeleteProductProperty = $row['DeleteProductProperty'];
            $role->ProductPropertySubGroupLimit = $row['ProductPropertySubGroupLimit'];
            $role->AllowedProductPropertySubGroups = $row['AllowedProductPropertySubGroups'];
            $role->PaymentMethods = $row['PaymentMethods'];
//            $role->InsertPaymentMethod =  $row['InsertPaymentMethod'];
            $role->EditPaymentMethod = $row['EditPaymentMethod'];
//            $role->DeletePaymentMethod =  $row['DeletePaymentMethod'];
            $role->Opinions = $row['Opinions'];
            $role->EditOpinion = $row['EditOpinion'];
            $role->DeleteOpinion = $row['DeleteOpinion'];
            $role->Feeds = $row['Feeds'];
            $role->InsertFeed = $row['InsertFeed'];
            $role->EditFeed = $row['EditFeed'];
            $role->DeleteFeed = $row['DeleteFeed'];
            $role->FeedSendEmail = $row['FeedSendEmail'];
            $role->Guarantees = $row['Guarantees'];
            $role->InsertGuarantee = $row['InsertGuarantee'];
            $role->EditGuarantee = $row['EditGuarantee'];
            $role->DeleteGuarantee = $row['DeleteGuarantee'];
            $role->Colors = $row['Colors'];
            $role->InsertColor = $row['InsertColor'];
            $role->EditColor = $row['EditColor'];
            $role->DeleteColor = $row['DeleteColor'];
            $role->Services = $row['Services'];
            $role->InsertService = $row['InsertService'];
            $role->EditService = $row['EditService'];
            $role->DeleteService = $row['DeleteService'];
            $role->Groups = $row['Groups'];
            $role->InsertGroup = $row['InsertGroup'];
            $role->EditGroup = $row['EditGroup'];
            $role->DeleteGroup = $row['DeleteGroup'];
            $role->SubGroups = $row['SubGroups'];
            $role->InsertSubGroup = $row['InsertSubGroup'];
            $role->EditSubGroup = $row['EditSubGroup'];
            $role->DeleteSubGroup = $row['DeleteSubGroup'];
            $role->SupperGroups = $row['SupperGroups'];
            $role->InsertSupperGroup = $row['InsertSupperGroup'];
            $role->EditSupperGroup = $row['EditSupperGroup'];
            $role->DeleteSupperGroup = $row['DeleteSupperGroup'];
            $role->SupperGroups = $row['SupperGroups'];
            $role->InsertSupperGroup = $row['InsertSupperGroup'];
            $role->EditSupperGroup = $row['EditSupperGroup'];
            $role->DeleteSupperGroup = $row['DeleteSupperGroup'];
            $role->Roles = $row['Roles'];
            $role->InsertRole = $row['InsertRole'];
            $role->EditRole = $row['EditRole'];
            $role->DeleteRole = $row['DeleteRole'];
            $role->Stats = $row['Stats'];
            $role->Settings = $row['Settings'];
            $role->ColorSettings = $row['ColorSettings'];
            $role->MenuSettings = $row['MenuSettings'];
            $role->SendSMS = $row['SendSMS'];
            $role->SpecialOffers = $row['SpecialOffers'];
            $role->InsertSpecialOffer = $row['InsertSpecialOffer'];
            $role->EditSpecialOffer = $row['EditSpecialOffer'];
            $role->DeleteSpecialOffer = $row['DeleteSpecialOffer'];
            return $role;
        }
    }

    public function FindOneRoleNameBasedOnId($id)
    {
        $SQL = "Select Name From roles Where RoleId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Name'];
        }
    }

    public function Fill()
    {
        $SQL = "Select * FROM roles ";
        $results = $this->da->execSelect($SQL);
        $roles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $role = new Role();
            $role->RoleId = $row['RoleId'];
            $role->Name = $row['Name'];
            $role->News = $row['News'];
            $role->InsertNews = $row['InsertNews'];
            $role->EditNews = $row['EditNews'];
            $role->DeleteNews = $row['DeleteNews'];
            $role->NewsApprove = $row['NewsApprove'];
            $role->ProductApprove = $row['ProductApprove'];
            $role->Products = $row['Products'];
            $role->InsertProduct = $row['InsertProduct'];
            $role->EditProduct = $row['EditProduct'];
            $role->DeleteProduct = $row['DeleteProduct'];
            $role->ProductGroupLimit = $row['ProductGroupLimit'];
            $role->BrandLimit = $row['BrandLimit'];
            $role->AllowedProductGroups = $row['AllowedProductGroups'];
            $role->AllowedProductSubGroups = $row['AllowedProductSubGroups'];
            $role->AllowedProductSupperGroups = $row['AllowedProductSupperGroups'];
            $role->AllowedBrands = $row['AllowedBrands'];
            $role->UserCoupons = $row['UserCoupons'];
            $role->InsertUserCoupon = $row['InsertUserCoupon'];
            $role->EditUserCoupon = $row['EditUserCoupon'];
            $role->DeleteUserCoupon = $row['DeleteUserCoupon'];
            $role->LinkBoxes = $row['LinkBoxes'];
            $role->InsertLinkBox = $row['InsertLinkBox'];
            $role->EditLinkBox = $row['EditLinkBox'];
            $role->DeleteLinkBox = $row['DeleteLinkBox'];
            $role->LinkBoxGroup = $row['LinkBoxGroup'];
            $role->Users = $row['Users'];
            $role->InsertUser = $row['InsertUser'];
            $role->EditUser = $row['EditUser'];
            $role->DeleteUser = $row['DeleteUser'];
            $role->Slides = $row['Slides'];
            $role->InsertSlide = $row['InsertSlide'];
            $role->EditSlide = $row['EditSlide'];
            $role->DeleteSlide = $row['DeleteSlide'];
            $role->Thumbs = $row['Thumbs'];
            $role->InsertThumb = $row['InsertThumb'];
            $role->EditThumb = $row['EditThumb'];
            $role->DeleteThumb = $row['DeleteThumb'];
            $role->ProductCoupons = $row['ProductCoupons'];
            $role->InsertProductCoupon = $row['InsertProductCoupon'];
            $role->EditProductCoupon = $row['EditProductCoupon'];
            $role->DeleteProductCoupon = $row['DeleteProductCoupon'];
            $role->FactorProducts = $row['FactorProducts'];
            $role->EditFactorProduct = $row['EditFactorProduct'];
            $role->Orders = $row['Orders'];
            $role->EditOrder = $row['EditOrder'];
            $role->Panels = $row['Panels'];
            $role->EditPanel = $row['EditPanel'];
            $role->Prices = $row['Prices'];
            $role->InsertPrice = $row['InsertPrice'];
            $role->EditPrice = $row['EditPrice'];
            $role->DeletePrice = $row['DeletePrice'];
            $role->PriceChange = $row['PriceChange'];
            $role->ShippingMethods = $row['ShippingMethods'];
            $role->InsertShippingMethod = $row['InsertShippingMethod'];
            $role->EditShippingMethod = $row['EditShippingMethod'];
            $role->DeleteShippingMethod = $row['DeleteShippingMethod'];
            $role->Shippings = $row['Shippings'];
            $role->InsertShipping = $row['InsertShipping'];
            $role->EditShipping = $row['EditShipping'];
            $role->DeleteShipping = $row['DeleteShipping'];
            $role->Comments = $row['Comments'];
            $role->EditComment = $row['EditComment'];
            $role->DeleteComment = $row['DeleteComment'];
            $role->Discounts = $row['Discounts'];
            $role->EditDiscount = $row['EditDiscount'];
            $role->DeleteDiscount = $row['DeleteDiscount'];
            $role->Brands = $row['Brands'];
            $role->InsertBrand = $row['InsertBrand'];
            $role->EditBrand = $row['EditBrand'];
            $role->DeleteBrand = $row['DeleteBrand'];
            $role->Customers = $row['Customers'];
            $role->InsertCustomer = $row['InsertCustomer'];
            $role->EditCustomer = $row['EditCustomer'];
            $role->DeleteCustomer = $row['DeleteCustomer'];
            $role->ProductProperties = $row['ProductProperties'];
            $role->InsertProductProperty = $row['InsertProductProperty'];
            $role->EditProductProperty = $row['EditProductProperty'];
            $role->DeleteProductProperty = $row['DeleteProductProperty'];
            $role->ProductPropertySubGroupLimit = $row['ProductPropertySubGroupLimit'];
            $role->AllowedProductPropertySubGroups = $row['AllowedProductPropertySubGroups'];
            $role->PaymentMethods = $row['PaymentMethods'];
//            $role->InsertPaymentMethod =  $row['InsertPaymentMethod'];
            $role->EditPaymentMethod = $row['EditPaymentMethod'];
//            $role->DeletePaymentMethod =  $row['DeletePaymentMethod'];
            $role->Opinions = $row['Opinions'];
            $role->EditOpinion = $row['EditOpinion'];
            $role->DeleteOpinion = $row['DeleteOpinion'];
            $role->Feeds = $row['Feeds'];
            $role->InsertFeed = $row['InsertFeed'];
            $role->EditFeed = $row['EditFeed'];
            $role->DeleteFeed = $row['DeleteFeed'];
            $role->FeedSendEmail = $row['FeedSendEmail'];
            $role->Guarantees = $row['Guarantees'];
            $role->InsertGuarantee = $row['InsertGuarantee'];
            $role->EditGuarantee = $row['EditGuarantee'];
            $role->DeleteGuarantee = $row['DeleteGuarantee'];
            $role->Colors = $row['Colors'];
            $role->InsertColor = $row['InsertColor'];
            $role->EditColor = $row['EditColor'];
            $role->DeleteColor = $row['DeleteColor'];
            $role->Services = $row['Services'];
            $role->InsertService = $row['InsertService'];
            $role->EditService = $row['EditService'];
            $role->DeleteService = $row['DeleteService'];
            $role->Groups = $row['Groups'];
            $role->InsertGroup = $row['InsertGroup'];
            $role->EditGroup = $row['EditGroup'];
            $role->DeleteGroup = $row['DeleteGroup'];
            $role->SubGroups = $row['SubGroups'];
            $role->InsertSubGroup = $row['InsertSubGroup'];
            $role->EditSubGroup = $row['EditSubGroup'];
            $role->DeleteSubGroup = $row['DeleteSubGroup'];
            $role->SupperGroups = $row['SupperGroups'];
            $role->InsertSupperGroup = $row['InsertSupperGroup'];
            $role->EditSupperGroup = $row['EditSupperGroup'];
            $role->DeleteSupperGroup = $row['DeleteSupperGroup'];
            $role->SupperGroups = $row['SupperGroups'];
            $role->InsertSupperGroup = $row['InsertSupperGroup'];
            $role->EditSupperGroup = $row['EditSupperGroup'];
            $role->DeleteSupperGroup = $row['DeleteSupperGroup'];
            $role->Roles = $row['Roles'];
            $role->InsertRole = $row['InsertRole'];
            $role->EditRole = $row['EditRole'];
            $role->DeleteRole = $row['DeleteRole'];
            $role->Stats = $row['Stats'];
            $role->Settings = $row['Settings'];
            $role->ColorSettings = $row['ColorSettings'];
            $role->MenuSettings = $row['MenuSettings'];
            $role->SendSMS = $row['SendSMS'];
            $role->SpecialOffers = $row['SpecialOffers'];
            $role->InsertSpecialOffer = $row['InsertSpecialOffer'];
            $role->EditSpecialOffer = $row['EditSpecialOffer'];
            $role->DeleteSpecialOffer = $row['DeleteSpecialOffer'];
            $roles[$i] = $role;
            $i++;
        }
        return $roles;
    }
}