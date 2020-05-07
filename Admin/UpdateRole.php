<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RoleDataSource.inc';

$role = new Role();

$role->RoleId = $_POST["id"];
$role->Name = $_POST["name"];
if (isset($_POST['news'])) {
    $role->News = 1;
} else {
    $role->News = 0;
}

if (isset($_POST['insertnews'])) {
    $role->InsertNews = 1;
} else {
    $role->InsertNews = 0;
}

if (isset($_POST['editnews'])) {
    $role->EditNews = 1;
} else {
    $role->EditNews = 0;
}

if (isset($_POST['deletenews'])) {
    $role->DeleteNews = 1;
} else {
    $role->DeleteNews = 0;
}
if (isset($_POST['newsapprove'])) {
    $role->NewsApprove = 1;
} else {
    $role->NewsApprove = 0;
}
if (isset($_POST['productapprove'])) {
    $role->ProductApprove = 1;
} else {
    $role->ProductApprove = 0;
}
if (isset($_POST['products'])) {
    $role->Products = 1;
} else {
    $role->Products = 0;
}

if (isset($_POST['insertproduct'])) {
    $role->InsertProduct = 1;
} else {
    $role->InsertProduct = 0;
}

if (isset($_POST['editproduct'])) {
    $role->EditProduct = 1;
} else {
    $role->EditProduct = 0;
}

if (isset($_POST['deleteproduct'])) {
    $role->DeleteProduct = 1;
} else {
    $role->DeleteProduct = 0;
}

if (isset($_POST['productgrouplimit'])) {
    $role->ProductGroupLimit = 1;
} else {
    $role->ProductGroupLimit = 0;
}

$role->AllowedProductGroups = "";
$role->AllowedProductSubGroups = "";
$role->AllowedProductSupperGroups = "";
if(isset($_POST['groupcheck_list']) && isset($_POST['subgroupcheck_list']) && isset($_POST['suppergroupcheck_list'])){
    foreach ($_POST['groupcheck_list'] as $c) {
        $role->AllowedProductGroups .=  "," . $c ;
    }
    foreach ($_POST['subgroupcheck_list'] as $c) {
        $role->AllowedProductSubGroups .= "," . $c;
    }
    foreach ($_POST['suppergroupcheck_list'] as $c) {
        $role->AllowedProductSupperGroups .=  "," . $c ;
    }
}

$role->AllowedBrands = "";
if (isset($_POST['brandcheck_list'])) {
    foreach ($_POST['brandcheck_list'] as $c) {
        $role->AllowedBrands .= "," . $c;
    }
}

//-------heh---------
if (isset($_POST['productproperties'])) {
    $role->ProductProperties = 1;
} else {
    $role->ProductProperties = 0;
}
if (isset($_POST['insertproductproperty'])) {
    $role->InsertProductProperty = 1;
} else {
    $role->InsertProductProperty = 0;
}

if (isset($_POST['editproductproperty'])) {
    $role->EditProductProperty = 1;
} else {
    $role->EditProductProperty = 0;
}

if (isset($_POST['deleteproductproperty'])) {
    $role->DeleteProductProperty = 1;
} else {
    $role->DeleteProductProperty = 0;
}

if (isset($_POST['productpropertysubgrouplimit'])) {
    $role->ProductPropertySubGroupLimit = 1;
} else {
    $role->ProductPropertySubGroupLimit = 0;
}

$role->AllowedProductPropertySubGroups = "";
if(isset($_POST['subgroupcheck_list2'])){
    foreach ($_POST['subgroupcheck_list2'] as $c2) {
        $role->AllowedProductPropertySubGroups .= "," . $c2;
    }
}

if (isset($_POST['brandlimit'])) {
    $role->BrandLimit = 1;
} else {
    $role->BrandLimit = 0;
}

//-----------------------HAHA-------------
if (isset($_POST['users'])) {
    $role->Users = 1;
} else {
    $role->Users = 0;
}
if (isset($_POST['insertuser'])) {
    $role->InsertUser = 1;
} else {
    $role->InsertUser = 0;
}
if (isset($_POST['edituser'])) {
    $role->EditUser = 1;
} else {
    $role->EditUser = 0;
}
if (isset($_POST['deleteuser'])) {
    $role->DeleteUser = 1;
} else {
    $role->DeleteUser = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['usercoupons'])) {
    $role->UserCoupons = 1;
} else {
    $role->UserCoupons = 0;
}
if (isset($_POST['insertusercoupon'])) {
    $role->InsertUserCoupon = 1;
} else {
    $role->InsertUserCoupon = 0;
}
if (isset($_POST['editusercoupon'])) {
    $role->EditUserCoupon = 1;
} else {
    $role->EditUserCoupon = 0;
}
if (isset($_POST['deleteusercoupon'])) {
    $role->DeleteUserCoupon = 1;
} else {
    $role->DeleteUserCoupon = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['productcoupons'])) {
    $role->ProductCoupons = 1;
} else {
    $role->ProductCoupons = 0;
}
if (isset($_POST['insertproductcoupon'])) {
    $role->InsertProductCoupon = 1;
} else {
    $role->InsertProductCoupon = 0;
}
if (isset($_POST['editproductcoupon'])) {
    $role->EditProductCoupon = 1;
} else {
    $role->EditProductCoupon = 0;
}
if (isset($_POST['deleteproductcoupon'])) {
    $role->DeleteProductCoupon = 1;
} else {
    $role->DeleteProductCoupon = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['factorproducts'])) {
    $role->FactorProducts = 1;
} else {
    $role->FactorProducts = 0;
}
if (isset($_POST['editfactorproduct'])) {
    $role->EditFactorProduct = 1;
} else {
    $role->EditFactorProduct = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['orders'])) {
    $role->Orders = 1;
} else {
    $role->Orders = 0;
}
if (isset($_POST['editorders'])) {
    $role->EditOrder = 1;
} else {
    $role->EditOrder = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['panels'])) {
    $role->Panels = 1;
} else {
    $role->Panels = 0;
}
if (isset($_POST['editpanels'])) {
    $role->EditPanel = 1;
} else {
    $role->EditPanel = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['shippingmethods'])) {
    $role->ShippingMethods = 1;
} else {
    $role->ShippingMethods = 0;
}
if (isset($_POST['insertshippingmethod'])) {
    $role->InsertShippingMethod = 1;
} else {
    $role->InsertShippingMethod = 0;
}
if (isset($_POST['editshippingmethod'])) {
    $role->EditShippingMethod = 1;
} else {
    $role->EditShippingMethod = 0;
}
if (isset($_POST['deleteshippingmethod'])) {
    $role->DeleteShippingMethod = 1;
} else {
    $role->DeleteShippingMethod = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['shippings'])) {
    $role->Shippings = 1;
} else {
    $role->Shippings = 0;
}
if (isset($_POST['insertshipping'])) {
    $role->InsertShipping = 1;
} else {
    $role->InsertShipping = 0;
}
if (isset($_POST['editshipping'])) {
    $role->EditShipping = 1;
} else {
    $role->EditShipping = 0;
}
if (isset($_POST['deleteshipping'])) {
    $role->DeleteShipping = 1;
} else {
    $role->DeleteShipping = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['linkboxes'])) {
    $role->LinkBoxes = 1;
} else {
    $role->LinkBoxes = 0;
}
if (isset($_POST['insertlinkbox'])) {
    $role->InsertLinkBox = 1;
} else {
    $role->InsertLinkBox = 0;
}
if (isset($_POST['editlinkbox'])) {
    $role->EditLinkBox = 1;
} else {
    $role->EditLinkBox = 0;
}
if (isset($_POST['deletelinkbox'])) {
    $role->DeleteLinkBox = 1;
} else {
    $role->DeleteLinkBox = 0;
}
if (isset($_POST['linkboxgroup'])) {
    $role->LinkBoxGroup = 1;
} else {
    $role->LinkBoxGroup = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['specialoffers'])) {
    $role->SpecialOffers = 1;
} else {
    $role->SpecialOffers = 0;
}
if (isset($_POST['insertspecialoffer'])) {
    $role->InsertSpecialOffer = 1;
} else {
    $role->InsertSpecialOffer = 0;
}
if (isset($_POST['editspecialoffer'])) {
    $role->EditSpecialOffer = 1;
} else {
    $role->EditSpecialOffer = 0;
}
if (isset($_POST['deletespecialoffer'])) {
    $role->DeleteSpecialOffer = 1;
} else {
    $role->DeleteSpecialOffer = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['slides'])) {
    $role->Slides = 1;
} else {
    $role->Slides = 0;
}
if (isset($_POST['insertslide'])) {
    $role->InsertSlide = 1;
} else {
    $role->InsertSlide = 0;
}
if (isset($_POST['editslide'])) {
    $role->EditSlide = 1;
} else {
    $role->EditSlide = 0;
}
if (isset($_POST['deleteslide'])) {
    $role->DeleteSlide = 1;
} else {
    $role->DeleteSlide = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['thumbs'])) {
    $role->Thumbs = 1;
} else {
    $role->Thumbs = 0;
}
if (isset($_POST['insertthumb'])) {
    $role->InsertThumb = 1;
} else {
    $role->InsertThumb = 0;
}
if (isset($_POST['editthumb'])) {
    $role->EditThumb = 1;
} else {
    $role->EditThumb = 0;
}
if (isset($_POST['deletethumb'])) {
    $role->DeleteThumb = 1;
} else {
    $role->DeleteThumb = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['prices'])) {
    $role->Prices = 1;
} else {
    $role->Prices = 0;
}
if (isset($_POST['insertprice'])) {
    $role->InsertPrice = 1;
} else {
    $role->InsertPrice = 0;
}
if (isset($_POST['editprice'])) {
    $role->EditPrice = 1;
} else {
    $role->EditPrice = 0;
}
if (isset($_POST['deleteprice'])) {
    $role->DeletePrice = 1;
} else {
    $role->DeletePrice = 0;
}
if (isset($_POST['pricechange'])) {
    $role->PriceChange = 1;
} else {
    $role->PriceChange = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['comments'])) {
    $role->Comments = 1;
} else {
    $role->Comments = 0;
}
if (isset($_POST['editcomment'])) {
    $role->EditComment = 1;
} else {
    $role->EditComment = 0;
}
if (isset($_POST['deletecomment'])) {
    $role->DeleteComment = 1;
} else {
    $role->DeleteComment = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['discounts'])) {
    $role->Discounts = 1;
} else {
    $role->Discounts = 0;
}
//if (isset($_POST['insertdiscount'])) {
//    $role->InsertDiscount = 1;
//} else {
//    $role->InsertDiscount = 0;
//}
if (isset($_POST['editdiscount'])) {
    $role->EditDiscount = 1;
} else {
    $role->EditDiscount = 0;
}
if (isset($_POST['deletediscount'])) {
    $role->DeleteDiscount = 1;
} else {
    $role->DeleteDiscount = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['brands'])) {
    $role->Brands = 1;
} else {
    $role->Brands = 0;
}
if (isset($_POST['insertbrand'])) {
    $role->InsertBrand = 1;
} else {
    $role->InsertBrand = 0;
}
if (isset($_POST['editbrand'])) {
    $role->EditBrand = 1;
} else {
    $role->EditBrand = 0;
}
if (isset($_POST['deletebrand'])) {
    $role->DeleteBrand = 1;
} else {
    $role->DeleteBrand = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['customers'])) {
    $role->Customers = 1;
} else {
    $role->Customers = 0;
}
if (isset($_POST['insertcustomer'])) {
    $role->InsertCustomer = 1;
} else {
    $role->InsertCustomer = 0;
}
if (isset($_POST['editcustomer'])) {
    $role->EditCustomer = 1;
} else {
    $role->EditCustomer = 0;
}
if (isset($_POST['deletecustomer'])) {
    $role->DeleteCustomer = 1;
} else {
    $role->DeleteCustomer = 0;
}
if (isset($_POST['sendsms'])) {
    $role->SendSMS = 1;
} else {
    $role->SendSMS = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['paymentmethods'])) {
    $role->PaymentMethods = 1;
} else {
    $role->PaymentMethod = 0;
}
//if (isset($_POST['insertpaymentmethod'])) {
//    $role->InsertPaymentMethod = 1;
//} else {
//    $role->InsertPaymentMethod = 0;
//}
if (isset($_POST['editpaymentmethod'])) {
    $role->EditPaymentMethod = 1;
} else {
    $role->EditPaymentMethod = 0;
}
//if (isset($_POST['deletepaymentmethod'])) {
//    $role->DeletePaymentMethod = 1;
//} else {
//    $role->DeletePaymentMethod = 0;
//}
//-----------------------HAHA-------------
if (isset($_POST['opinions'])) {
    $role->Opinions = 1;
} else {
    $role->Opinions = 0;
}
if (isset($_POST['editopinion'])) {
    $role->EditOpinion = 1;
} else {
    $role->EditOpinion = 0;
}
if (isset($_POST['deleteopinion'])) {
    $role->DeleteOpinion = 1;
} else {
    $role->DeleteOpinion = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['feeds'])) {
    $role->Feeds = 1;
} else {
    $role->Feeds = 0;
}
if (isset($_POST['insertfeed'])) {
    $role->InsertFeed = 1;
} else {
    $role->InsertFeed = 0;
}
if (isset($_POST['editfeed'])) {
    $role->EditFeed = 1;
} else {
    $role->EditFeed = 0;
}
if (isset($_POST['deletefeed'])) {
    $role->DeleteFeed = 1;
} else {
    $role->DeleteFeed = 0;
}
if (isset($_POST['feedsendemail'])) {
    $role->FeedSendEmail = 1;
} else {
    $role->FeedSendEmail = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['guarantees'])) {
    $role->Guarantees = 1;
} else {
    $role->Guarantees = 0;
}
if (isset($_POST['insertguarantee'])) {
    $role->InsertGuarantee = 1;
} else {
    $role->InsertGuarantee = 0;
}
if (isset($_POST['editguarantee'])) {
    $role->EditGuarantee = 1;
} else {
    $role->EditGuarantee = 0;
}
if (isset($_POST['deleteguarantee'])) {
    $role->DeleteGuarantee = 1;
} else {
    $role->DeleteGuarantee = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['colors'])) {
    $role->Colors = 1;
} else {
    $role->Colors = 0;
}
if (isset($_POST['insertcolor'])) {
    $role->InsertColor = 1;
} else {
    $role->InsertColor = 0;
}
if (isset($_POST['editcolor'])) {
    $role->EditColor = 1;
} else {
    $role->EditColor = 0;
}
if (isset($_POST['deletecolor'])) {
    $role->DeleteColor = 1;
} else {
    $role->DeleteColor = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['services'])) {
    $role->Services = 1;
} else {
    $role->Service = 0;
}
if (isset($_POST['insertservice'])) {
    $role->InsertService = 1;
} else {
    $role->InsertService = 0;
}
if (isset($_POST['editservice'])) {
    $role->EditService = 1;
} else {
    $role->EditService = 0;
}
if (isset($_POST['deleteservice'])) {
    $role->DeleteService = 1;
} else {
    $role->DeleteService = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['groups'])) {
    $role->Groups = 1;
} else {
    $role->Groups = 0;
}
if (isset($_POST['insertgroup'])) {
    $role->InsertGroup = 1;
} else {
    $role->InsertGroup = 0;
}
if (isset($_POST['editgroup'])) {
    $role->EditGroup = 1;
} else {
    $role->EditGroup = 0;
}
if (isset($_POST['deletegroup'])) {
    $role->DeleteGroup = 1;
} else {
    $role->DeleteGroup = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['subgroups'])) {
    $role->SubGroups = 1;
} else {
    $role->SubGroup = 0;
}
if (isset($_POST['insertsubgroup'])) {
    $role->InsertSubGroup = 1;
} else {
    $role->InsertSubGroup = 0;
}
if (isset($_POST['editsubgroup'])) {
    $role->EditSubGroup = 1;
} else {
    $role->EditSubGroup = 0;
}
if (isset($_POST['deletesubgroup'])) {
    $role->DeleteSubGroup = 1;
} else {
    $role->DeleteSubGroup = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['suppergroups'])) {
    $role->SupperGroups = 1;
} else {
    $role->SupperGroups = 0;
}
if (isset($_POST['insertsuppergroup'])) {
    $role->InsertSupperGroup = 1;
} else {
    $role->InsertSupperGroup = 0;
}
if (isset($_POST['editsuppergroup'])) {
    $role->EditSupperGroup = 1;
} else {
    $role->EditSupperGroup = 0;
}
if (isset($_POST['deletesuppergroup'])) {
    $role->DeleteSupperGroup = 1;
} else {
    $role->DeleteSupperGroup = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['roles'])) {
    $role->Roles = 1;
} else {
    $role->Roles = 0;
}
if (isset($_POST['insertrole'])) {
    $role->InsertRole = 1;
} else {
    $role->InsertRole = 0;
}
if (isset($_POST['editrole'])) {
    $role->EditRole = 1;
} else {
    $role->EditRole = 0;
}
if (isset($_POST['deleterole'])) {
    $role->DeleteRole = 1;
} else {
    $role->DeleteRole = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['stats'])) {
    $role->Stats = 1;
} else {
    $role->Stats = 0;
}
//-----------------------HAHA-------------
if (isset($_POST['settings'])) {
    $role->Settings = 1;
} else {
    $role->Settings = 0;
}
if (isset($_POST['colorsettings'])) {
    $role->ColorSettings = 1;
} else {
    $role->ColorSettings = 0;
}
if (isset($_POST['menusettings'])) {
    $role->MenuSettings = 1;
} else {
    $role->MenuSettings = 0;
}


$rlds = new RoleDataSource();
$rlds->open();
$rlds->Update($role);
$rlds->close();
header('Location:Roles.php');
