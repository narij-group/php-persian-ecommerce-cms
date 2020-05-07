<?php


/**
 * Class Role
 */
class Role
{
    /**
     * @var int
     */
    public $RoleId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var int
     */
    public $Products;
    /**
     * @var int
     */
    public $InsertProduct;
    /**
     * @var int
     */
    public $EditProduct;
    /**
     * @var int
     */
    public $DeleteProduct;
    /**
     * @var int
     */
    public $ProductGroupLimit;
    /**
     * @var string
     */
    public $AllowedProductGroups;
    /**
     * @var string
     */
    public $AllowedProductSubGroups;
    /**
     * @var string
     */
    public $AllowedProductSupperGroups;
    /**
     * @var int
     */
    public $UserCoupons;
    /**
     * @var int
     */
    public $InsertUserCoupon;
    /**
     * @var int
     */
    public $EditUserCoupon;
    /**
     * @var int
     */
    public $DeleteUserCoupon;
    /**
     * @var int
     */
    public $LinkBoxes;
    /**
     * @var int
     */
    public $InsertLinkBox;
    /**
     * @var int
     */
    public $EditLinkBox;
    /**
     * @var int
     */
    public $DeleteLinkBox;
    /**
     * @var int
     */
    public $LinkBoxGroup;
    /**
     * @var int
     */
    public $Users;
    /**
     * @var int
     */
    public $InsertUser;
    /**
     * @var int
     */
    public $EditUser;
    /**
     * @var int
     */
    public $DeleteUser;
    /**
     * @var int
     */
    public $Slides;
    /**
     * @var int
     */
    public $InsertSlide;
    /**
     * @var int
     */
    public $EditSlide;
    /**
     * @var int
     */
    public $DeleteSlide;
    /**
     * @var int
     */
    public $ProductCoupons;
    /**
     * @var int
     */
    public $InsertProductCoupon;
    /**
     * @var int
     */
    public $EditProductCoupon;
    /**
     * @var int
     */
    public $DeleteProductCoupon;
    /**
     * @var int
     */
    public $Thumbs;
    /**
     * @var int
     */
    public $InsertThumb;
    /**
     * @var int
     */
    public $EditThumb;
    /**
     * @var int
     */
    public $DeleteThumb;
    /**
     * @var int
     */
    public $FactorProducts;
    /**
     * @var int
     */
    public $EditFactorProduct;
    /**
     * @var int
     */
    public $Orders;
    /**
     * @var int
     */
    public $EditOrder;
    /**
     * @var int
     */
    public $Panels;
    /**
     * @var int
     */
    public $EditPanel;
    /**
     * @var int
     */
    public $Prices;
    /**
     * @var int
     */
    public $InsertPrice;
    /**
     * @var int
     */
    public $EditPrice;
    /**
     * @var int
     */
    public $DeletePrice;
    /**
     * @var int
     */
    public $PriceChange;
    /**
     * @var int
     */
    public $ShippingMethods;
    /**
     * @var int
     */
    public $InsertShippingMethod;
    /**
     * @var int
     */
    public $EditShippingMethod;
    /**
     * @var int
     */
    public $DeleteShippingMethod;
    /**
     * @var int
     */
    public $Shippings;
    /**
     * @var int
     */
    public $InsertShipping;
    /**
     * @var int
     */
    public $EditShipping;
    /**
     * @var int
     */
    public $DeleteShipping;
    /**
     * @var int
     */
    public $Comments;
    /**
     * @var int
     */
    public $EditComment;
    /**
     * @var int
     */
    public $DeleteComment;
    /**
     * @var int
     */
    public $Discounts;
    /**
     * @var int
     */
    public $EditDiscount;
    /**
     * @var int
     */
    public $DeleteDiscount;
    /**
     * @var int
     */
    public $Brands;
    /**
     * @var int
     */
    public $InsertBrand;
    /**
     * @var int
     */
    public $EditBrand;
    /**
     * @var int
     */
    public $DeleteBrand;
    /**
     * @var int
     */
    public $Customers;
    /**
     * @var int
     */
    public $InsertCustomer;
    /**
     * @var int
     */
    public $EditCustomer;
    /**
     * @var int
     */
    public $DeleteCustomer;
    /**
     * @var int
     */
    public $ProductProperties;
    /**
     * @var int
     */
    public $InsertProductProperty;
    /**
     * @var int
     */
    public $EditProductProperty;
    /**
     * @var int
     */
    public $DeleteProductProperty;
    /**
     * @var
     */
    public $ProductPropertySubGroupLimit;
    /**
     * @var string
     */
    public $AllowedProductPropertySubGroups;
    /**
     * @var
     */
    public $BrandLimit;
    /**
     * @var string
     */
    public $AllowedBrands;
    /**
     * @var int
     */
    public $PaymentMethods;
//    public $InsertPaymentMethod;
    /**
     * @var int
     */
    public $EditPaymentMethod;
//    public $DeletePaymentMethod;
    /**
     * @var int
     */
    public $Opinions;
    /**
     * @var int
     */
    public $EditOpinion;
    /**
     * @var int
     */
    public $DeleteOpinion;
    /**
     * @var int
     */
    public $Feeds;
    /**
     * @var int
     */
    public $InsertFeed;
    /**
     * @var int
     */
    public $EditFeed;
    /**
     * @var int
     */
    public $DeleteFeed;
    /**
     * @var int
     */
    public $FeedSendEmail;
    /**
     * @var int
     */
    public $Guarantees;
    /**
     * @var int
     */
    public $InsertGuarantee;
    /**
     * @var int
     */
    public $EditGuarantee;
    /**
     * @var int
     */
    public $DeleteGuarantee;
    /**
     * @var int
     */
    public $Colors;
    /**
     * @var int
     */
    public $InsertColor;
    /**
     * @var int
     */
    public $EditColor;
    /**
     * @var int
     */
    public $DeleteColor;
    /**
     * @var int
     */
    public $Services;
    /**
     * @var int
     */
    public $InsertService;
    /**
     * @var int
     */
    public $EditService;
    /**
     * @var int
     */
    public $DeleteService;
    /**
     * @var int
     */
    public $Groups;
    /**
     * @var int
     */
    public $InsertGroup;
    /**
     * @var int
     */
    public $EditGroup;
    /**
     * @var int
     */
    public $DeleteGroup;
    /**
     * @var int
     */
    public $SubGroups;
    /**
     * @var int
     */
    public $InsertSubGroup;
    /**
     * @var int
     */
    public $EditSubGroup;
    /**
     * @var int
     */
    public $DeleteSubGroup;
    /**
     * @var int
     */
    public $SupperGroups;
    /**
     * @var int
     */
    public $InsertSupperGroup;
    /**
     * @var int
     */
    public $EditSupperGroup;
    /**
     * @var int
     */
    public $DeleteSupperGroup;
    /**
     * @var int
     */
    public $Roles;
    /**
     * @var int
     */
    public $InsertRole;
    /**
     * @var int
     */
    public $EditRole;
    /**
     * @var int
     */
    public $DeleteRole;
    /**
     * @var int
     */
    public $Stats;
    /**
     * @var int
     */
    public $Settings;
    /**
     * @var int
     */
    public $MenuSettings;
    /**
     * @var int
     */
    public $ColorSettings;
    /**
     * @var int
     */
    public $SendSMS;
    /**
     * @var int
     */
    public $News;
    /**
     * @var int
     */
    public $InsertNews;
    /**
     * @var int
     */
    public $EditNews;
    /**
     * @var int
     */
    public $DeleteNews;
    /**
     * @var int
     */
    public $NewsApprove;
    /**
     * @var int
     */
    public $ProductApprove;
    /**
     * @var int
     */
    public $SpecialOffers;
    /**
     * @var int
     */
    public $InsertSpecialOffer;
    /**
     * @var int
     */
    public $EditSpecialOffer;
    /**
     * @var int
     */
    public $DeleteSpecialOffer;


    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->RoleId;
    }

    /**
     * @param int $RoleId
     */
    public function setRoleId($RoleId)
    {
        $this->RoleId = $RoleId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return int
     */
    public function getProducts()
    {
        return $this->Products;
    }

    /**
     * @param int $Products
     */
    public function setProducts($Products)
    {
        $this->Products = $Products;
    }

    /**
     * @return int
     */
    public function getInsertProduct()
    {
        return $this->InsertProduct;
    }

    /**
     * @param int $InsertProduct
     */
    public function setInsertProduct($InsertProduct)
    {
        $this->InsertProduct = $InsertProduct;
    }

    /**
     * @return int
     */
    public function getEditProduct()
    {
        return $this->EditProduct;
    }

    /**
     * @param int $EditProduct
     */
    public function setEditProduct($EditProduct)
    {
        $this->EditProduct = $EditProduct;
    }

    /**
     * @return int
     */
    public function getDeleteProduct()
    {
        return $this->DeleteProduct;
    }

    /**
     * @param int $DeleteProduct
     */
    public function setDeleteProduct($DeleteProduct)
    {
        $this->DeleteProduct = $DeleteProduct;
    }

    /**
     * @return int
     */
    public function getProductGroupLimit()
    {
        return $this->ProductGroupLimit;
    }

    /**
     * @param int $ProductGroupLimit
     */
    public function setProductGroupLimit($ProductGroupLimit)
    {
        $this->ProductGroupLimit = $ProductGroupLimit;
    }

    /**
     * @return string
     */
    public function getAllowedProductGroups()
    {
        return $this->AllowedProductGroups;
    }

    /**
     * @param string $AllowedProductGroups
     */
    public function setAllowedProductGroups($AllowedProductGroups)
    {
        $this->AllowedProductGroups = $AllowedProductGroups;
    }

    /**
     * @return string
     */
    public function getAllowedProductSubGroups()
    {
        return $this->AllowedProductSubGroups;
    }

    /**
     * @param string $AllowedProductSubGroups
     */
    public function setAllowedProductSubGroups($AllowedProductSubGroups)
    {
        $this->AllowedProductSubGroups = $AllowedProductSubGroups;
    }

    /**
     * @return string
     */
    public function getAllowedProductSupperGroups()
    {
        return $this->AllowedProductSupperGroups;
    }

    /**
     * @param string $AllowedProductSupperGroups
     */
    public function setAllowedProductSupperGroups($AllowedProductSupperGroups)
    {
        $this->AllowedProductSupperGroups = $AllowedProductSupperGroups;
    }

    /**
     * @return int
     */
    public function getUserCoupons()
    {
        return $this->UserCoupons;
    }

    /**
     * @param int $UserCoupons
     */
    public function setUserCoupons($UserCoupons)
    {
        $this->UserCoupons = $UserCoupons;
    }

    /**
     * @return int
     */
    public function getInsertUserCoupon()
    {
        return $this->InsertUserCoupon;
    }

    /**
     * @param int $InsertUserCoupon
     */
    public function setInsertUserCoupon($InsertUserCoupon)
    {
        $this->InsertUserCoupon = $InsertUserCoupon;
    }

    /**
     * @return int
     */
    public function getEditUserCoupon()
    {
        return $this->EditUserCoupon;
    }

    /**
     * @param int $EditUserCoupon
     */
    public function setEditUserCoupon($EditUserCoupon)
    {
        $this->EditUserCoupon = $EditUserCoupon;
    }

    /**
     * @return int
     */
    public function getDeleteUserCoupon()
    {
        return $this->DeleteUserCoupon;
    }

    /**
     * @param int $DeleteUserCoupon
     */
    public function setDeleteUserCoupon($DeleteUserCoupon)
    {
        $this->DeleteUserCoupon = $DeleteUserCoupon;
    }

    /**
     * @return int
     */
    public function getLinkBoxes()
    {
        return $this->LinkBoxes;
    }

    /**
     * @param int $LinkBoxes
     */
    public function setLinkBoxes($LinkBoxes)
    {
        $this->LinkBoxes = $LinkBoxes;
    }

    /**
     * @return int
     */
    public function getInsertLinkBox()
    {
        return $this->InsertLinkBox;
    }

    /**
     * @param int $InsertLinkBox
     */
    public function setInsertLinkBox($InsertLinkBox)
    {
        $this->InsertLinkBox = $InsertLinkBox;
    }

    /**
     * @return int
     */
    public function getEditLinkBox()
    {
        return $this->EditLinkBox;
    }

    /**
     * @param int $EditLinkBox
     */
    public function setEditLinkBox($EditLinkBox)
    {
        $this->EditLinkBox = $EditLinkBox;
    }

    /**
     * @return int
     */
    public function getDeleteLinkBox()
    {
        return $this->DeleteLinkBox;
    }

    /**
     * @param int $DeleteLinkBox
     */
    public function setDeleteLinkBox($DeleteLinkBox)
    {
        $this->DeleteLinkBox = $DeleteLinkBox;
    }

    /**
     * @return int
     */
    public function getLinkBoxGroup()
    {
        return $this->LinkBoxGroup;
    }

    /**
     * @param int $LinkBoxGroup
     */
    public function setLinkBoxGroup($LinkBoxGroup)
    {
        $this->LinkBoxGroup = $LinkBoxGroup;
    }

    /**
     * @return int
     */
    public function getUsers()
    {
        return $this->Users;
    }

    /**
     * @param int $Users
     */
    public function setUsers($Users)
    {
        $this->Users = $Users;
    }

    /**
     * @return int
     */
    public function getInsertUser()
    {
        return $this->InsertUser;
    }

    /**
     * @param int $InsertUser
     */
    public function setInsertUser($InsertUser)
    {
        $this->InsertUser = $InsertUser;
    }

    /**
     * @return int
     */
    public function getEditUser()
    {
        return $this->EditUser;
    }

    /**
     * @param int $EditUser
     */
    public function setEditUser($EditUser)
    {
        $this->EditUser = $EditUser;
    }

    /**
     * @return int
     */
    public function getDeleteUser()
    {
        return $this->DeleteUser;
    }

    /**
     * @param int $DeleteUser
     */
    public function setDeleteUser($DeleteUser)
    {
        $this->DeleteUser = $DeleteUser;
    }

    /**
     * @return int
     */
    public function getSlides()
    {
        return $this->Slides;
    }

    /**
     * @param int $Slides
     */
    public function setSlides($Slides)
    {
        $this->Slides = $Slides;
    }

    /**
     * @return int
     */
    public function getInsertSlide()
    {
        return $this->InsertSlide;
    }

    /**
     * @param int $InsertSlide
     */
    public function setInsertSlide($InsertSlide)
    {
        $this->InsertSlide = $InsertSlide;
    }

    /**
     * @return int
     */
    public function getEditSlide()
    {
        return $this->EditSlide;
    }

    /**
     * @param int $EditSlide
     */
    public function setEditSlide($EditSlide)
    {
        $this->EditSlide = $EditSlide;
    }

    /**
     * @return int
     */
    public function getDeleteSlide()
    {
        return $this->DeleteSlide;
    }

    /**
     * @param int $DeleteSlide
     */
    public function setDeleteSlide($DeleteSlide)
    {
        $this->DeleteSlide = $DeleteSlide;
    }

    /**
     * @return int
     */
    public function getProductCoupons()
    {
        return $this->ProductCoupons;
    }

    /**
     * @param int $ProductCoupons
     */
    public function setProductCoupons($ProductCoupons)
    {
        $this->ProductCoupons = $ProductCoupons;
    }

    /**
     * @return int
     */
    public function getInsertProductCoupon()
    {
        return $this->InsertProductCoupon;
    }

    /**
     * @param int $InsertProductCoupon
     */
    public function setInsertProductCoupon($InsertProductCoupon)
    {
        $this->InsertProductCoupon = $InsertProductCoupon;
    }

    /**
     * @return int
     */
    public function getEditProductCoupon()
    {
        return $this->EditProductCoupon;
    }

    /**
     * @param int $EditProductCoupon
     */
    public function setEditProductCoupon($EditProductCoupon)
    {
        $this->EditProductCoupon = $EditProductCoupon;
    }

    /**
     * @return int
     */
    public function getDeleteProductCoupon()
    {
        return $this->DeleteProductCoupon;
    }

    /**
     * @param int $DeleteProductCoupon
     */
    public function setDeleteProductCoupon($DeleteProductCoupon)
    {
        $this->DeleteProductCoupon = $DeleteProductCoupon;
    }

    /**
     * @return int
     */
    public function getThumbs()
    {
        return $this->Thumbs;
    }

    /**
     * @param int $Thumbs
     */
    public function setThumbs($Thumbs)
    {
        $this->Thumbs = $Thumbs;
    }

    /**
     * @return int
     */
    public function getInsertThumb()
    {
        return $this->InsertThumb;
    }

    /**
     * @param int $InsertThumb
     */
    public function setInsertThumb($InsertThumb)
    {
        $this->InsertThumb = $InsertThumb;
    }

    /**
     * @return int
     */
    public function getEditThumb()
    {
        return $this->EditThumb;
    }

    /**
     * @param int $EditThumb
     */
    public function setEditThumb($EditThumb)
    {
        $this->EditThumb = $EditThumb;
    }

    /**
     * @return int
     */
    public function getDeleteThumb()
    {
        return $this->DeleteThumb;
    }

    /**
     * @param int $DeleteThumb
     */
    public function setDeleteThumb($DeleteThumb)
    {
        $this->DeleteThumb = $DeleteThumb;
    }

    /**
     * @return int
     */
    public function getFactorProducts()
    {
        return $this->FactorProducts;
    }

    /**
     * @param int $FactorProducts
     */
    public function setFactorProducts($FactorProducts)
    {
        $this->FactorProducts = $FactorProducts;
    }

    /**
     * @return int
     */
    public function getEditFactorProduct()
    {
        return $this->EditFactorProduct;
    }

    /**
     * @param int $EditFactorProduct
     */
    public function setEditFactorProduct($EditFactorProduct)
    {
        $this->EditFactorProduct = $EditFactorProduct;
    }

    /**
     * @return int
     */
    public function getOrders()
    {
        return $this->Orders;
    }

    /**
     * @param int $Orders
     */
    public function setOrders($Orders)
    {
        $this->Orders = $Orders;
    }

    /**
     * @return int
     */
    public function getEditOrder()
    {
        return $this->EditOrder;
    }

    /**
     * @param int $EditOrder
     */
    public function setEditOrder($EditOrder)
    {
        $this->EditOrder = $EditOrder;
    }

    /**
     * @return int
     */
    public function getPanels()
    {
        return $this->Panels;
    }

    /**
     * @param int $Panels
     */
    public function setPanels($Panels)
    {
        $this->Panels = $Panels;
    }

    /**
     * @return int
     */
    public function getEditPanel()
    {
        return $this->EditPanel;
    }

    /**
     * @param int $EditPanel
     */
    public function setEditPanel($EditPanel)
    {
        $this->EditPanel = $EditPanel;
    }

    /**
     * @return int
     */
    public function getPrices()
    {
        return $this->Prices;
    }

    /**
     * @param int $Prices
     */
    public function setPrices($Prices)
    {
        $this->Prices = $Prices;
    }

    /**
     * @return int
     */
    public function getInsertPrice()
    {
        return $this->InsertPrice;
    }

    /**
     * @param int $InsertPrice
     */
    public function setInsertPrice($InsertPrice)
    {
        $this->InsertPrice = $InsertPrice;
    }

    /**
     * @return int
     */
    public function getEditPrice()
    {
        return $this->EditPrice;
    }

    /**
     * @param int $EditPrice
     */
    public function setEditPrice($EditPrice)
    {
        $this->EditPrice = $EditPrice;
    }

    /**
     * @return int
     */
    public function getDeletePrice()
    {
        return $this->DeletePrice;
    }

    /**
     * @param int $DeletePrice
     */
    public function setDeletePrice($DeletePrice)
    {
        $this->DeletePrice = $DeletePrice;
    }

    /**
     * @return int
     */
    public function getPriceChange()
    {
        return $this->PriceChange;
    }

    /**
     * @param int $PriceChange
     */
    public function setPriceChange($PriceChange)
    {
        $this->PriceChange = $PriceChange;
    }

    /**
     * @return int
     */
    public function getShippingMethods()
    {
        return $this->ShippingMethods;
    }

    /**
     * @param int $ShippingMethods
     */
    public function setShippingMethods($ShippingMethods)
    {
        $this->ShippingMethods = $ShippingMethods;
    }

    /**
     * @return int
     */
    public function getInsertShippingMethod()
    {
        return $this->InsertShippingMethod;
    }

    /**
     * @param int $InsertShippingMethod
     */
    public function setInsertShippingMethod($InsertShippingMethod)
    {
        $this->InsertShippingMethod = $InsertShippingMethod;
    }

    /**
     * @return int
     */
    public function getEditShippingMethod()
    {
        return $this->EditShippingMethod;
    }

    /**
     * @param int $EditShippingMethod
     */
    public function setEditShippingMethod($EditShippingMethod)
    {
        $this->EditShippingMethod = $EditShippingMethod;
    }

    /**
     * @return int
     */
    public function getDeleteShippingMethod()
    {
        return $this->DeleteShippingMethod;
    }

    /**
     * @param int $DeleteShippingMethod
     */
    public function setDeleteShippingMethod($DeleteShippingMethod)
    {
        $this->DeleteShippingMethod = $DeleteShippingMethod;
    }

    /**
     * @return int
     */
    public function getShippings()
    {
        return $this->Shippings;
    }

    /**
     * @param int $Shippings
     */
    public function setShippings($Shippings)
    {
        $this->Shippings = $Shippings;
    }

    /**
     * @return int
     */
    public function getInsertShipping()
    {
        return $this->InsertShipping;
    }

    /**
     * @param int $InsertShipping
     */
    public function setInsertShipping($InsertShipping)
    {
        $this->InsertShipping = $InsertShipping;
    }

    /**
     * @return int
     */
    public function getEditShipping()
    {
        return $this->EditShipping;
    }

    /**
     * @param int $EditShipping
     */
    public function setEditShipping($EditShipping)
    {
        $this->EditShipping = $EditShipping;
    }

    /**
     * @return int
     */
    public function getDeleteShipping()
    {
        return $this->DeleteShipping;
    }

    /**
     * @param int $DeleteShipping
     */
    public function setDeleteShipping($DeleteShipping)
    {
        $this->DeleteShipping = $DeleteShipping;
    }

    /**
     * @return int
     */
    public function getComments()
    {
        return $this->Comments;
    }

    /**
     * @param int $Comments
     */
    public function setComments($Comments)
    {
        $this->Comments = $Comments;
    }

    /**
     * @return int
     */
    public function getEditComment()
    {
        return $this->EditComment;
    }

    /**
     * @param int $EditComment
     */
    public function setEditComment($EditComment)
    {
        $this->EditComment = $EditComment;
    }

    /**
     * @return int
     */
    public function getDeleteComment()
    {
        return $this->DeleteComment;
    }

    /**
     * @param int $DeleteComment
     */
    public function setDeleteComment($DeleteComment)
    {
        $this->DeleteComment = $DeleteComment;
    }

    /**
     * @return int
     */
    public function getDiscounts()
    {
        return $this->Discounts;
    }

    /**
     * @param int $Discounts
     */
    public function setDiscounts($Discounts)
    {
        $this->Discounts = $Discounts;
    }

    /**
     * @return int
     */
    public function getEditDiscount()
    {
        return $this->EditDiscount;
    }

    /**
     * @param int $EditDiscount
     */
    public function setEditDiscount($EditDiscount)
    {
        $this->EditDiscount = $EditDiscount;
    }

    /**
     * @return int
     */
    public function getDeleteDiscount()
    {
        return $this->DeleteDiscount;
    }

    /**
     * @param int $DeleteDiscount
     */
    public function setDeleteDiscount($DeleteDiscount)
    {
        $this->DeleteDiscount = $DeleteDiscount;
    }

    /**
     * @return int
     */
    public function getBrands()
    {
        return $this->Brands;
    }

    /**
     * @param int $Brands
     */
    public function setBrands($Brands)
    {
        $this->Brands = $Brands;
    }

    /**
     * @return int
     */
    public function getInsertBrand()
    {
        return $this->InsertBrand;
    }

    /**
     * @param int $InsertBrand
     */
    public function setInsertBrand($InsertBrand)
    {
        $this->InsertBrand = $InsertBrand;
    }

    /**
     * @return int
     */
    public function getEditBrand()
    {
        return $this->EditBrand;
    }

    /**
     * @param int $EditBrand
     */
    public function setEditBrand($EditBrand)
    {
        $this->EditBrand = $EditBrand;
    }

    /**
     * @return int
     */
    public function getDeleteBrand()
    {
        return $this->DeleteBrand;
    }

    /**
     * @param int $DeleteBrand
     */
    public function setDeleteBrand($DeleteBrand)
    {
        $this->DeleteBrand = $DeleteBrand;
    }

    /**
     * @return int
     */
    public function getCustomers()
    {
        return $this->Customers;
    }

    /**
     * @param int $Customers
     */
    public function setCustomers($Customers)
    {
        $this->Customers = $Customers;
    }

    /**
     * @return int
     */
    public function getInsertCustomer()
    {
        return $this->InsertCustomer;
    }

    /**
     * @param int $InsertCustomer
     */
    public function setInsertCustomer($InsertCustomer)
    {
        $this->InsertCustomer = $InsertCustomer;
    }

    /**
     * @return int
     */
    public function getEditCustomer()
    {
        return $this->EditCustomer;
    }

    /**
     * @param int $EditCustomer
     */
    public function setEditCustomer($EditCustomer)
    {
        $this->EditCustomer = $EditCustomer;
    }

    /**
     * @return int
     */
    public function getDeleteCustomer()
    {
        return $this->DeleteCustomer;
    }

    /**
     * @param int $DeleteCustomer
     */
    public function setDeleteCustomer($DeleteCustomer)
    {
        $this->DeleteCustomer = $DeleteCustomer;
    }

    /**
     * @return int
     */
    public function getProductProperties()
    {
        return $this->ProductProperties;
    }

    /**
     * @param int $ProductProperties
     */
    public function setProductProperties($ProductProperties)
    {
        $this->ProductProperties = $ProductProperties;
    }

    /**
     * @return int
     */
    public function getInsertProductProperty()
    {
        return $this->InsertProductProperty;
    }

    /**
     * @param int $InsertProductProperty
     */
    public function setInsertProductProperty($InsertProductProperty)
    {
        $this->InsertProductProperty = $InsertProductProperty;
    }

    /**
     * @return int
     */
    public function getEditProductProperty()
    {
        return $this->EditProductProperty;
    }

    /**
     * @param int $EditProductProperty
     */
    public function setEditProductProperty($EditProductProperty)
    {
        $this->EditProductProperty = $EditProductProperty;
    }

    /**
     * @return int
     */
    public function getDeleteProductProperty()
    {
        return $this->DeleteProductProperty;
    }

    /**
     * @param int $DeleteProductProperty
     */
    public function setDeleteProductProperty($DeleteProductProperty)
    {
        $this->DeleteProductProperty = $DeleteProductProperty;
    }

    /**
     * @return mixed
     */
    public function getProductPropertySubGroupLimit()
    {
        return $this->ProductPropertySubGroupLimit;
    }

    /**
     * @param mixed $ProductPropertySubGroupLimit
     */
    public function setProductPropertySubGroupLimit($ProductPropertySubGroupLimit)
    {
        $this->ProductPropertySubGroupLimit = $ProductPropertySubGroupLimit;
    }

    /**
     * @return string
     */
    public function getAllowedProductPropertySubGroups()
    {
        return $this->AllowedProductPropertySubGroups;
    }

    /**
     * @param string $AllowedProductPropertySubGroups
     */
    public function setAllowedProductPropertySubGroups($AllowedProductPropertySubGroups)
    {
        $this->AllowedProductPropertySubGroups = $AllowedProductPropertySubGroups;
    }

    /**
     * @return mixed
     */
    public function getBrandLimit()
    {
        return $this->BrandLimit;
    }

    /**
     * @param mixed $BrandLimit
     */
    public function setBrandLimit($BrandLimit)
    {
        $this->BrandLimit = $BrandLimit;
    }

    /**
     * @return string
     */
    public function getAllowedBrands()
    {
        return $this->AllowedBrands;
    }

    /**
     * @param string $AllowedBrands
     */
    public function setAllowedBrands($AllowedBrands)
    {
        $this->AllowedBrands = $AllowedBrands;
    }

    /**
     * @return int
     */
    public function getPaymentMethods()
    {
        return $this->PaymentMethods;
    }

    /**
     * @param int $PaymentMethods
     */
    public function setPaymentMethods($PaymentMethods)
    {
        $this->PaymentMethods = $PaymentMethods;
    }

    /**
     * @return int
     */
    public function getEditPaymentMethod()
    {
        return $this->EditPaymentMethod;
    }

    /**
     * @param int $EditPaymentMethod
     */
    public function setEditPaymentMethod($EditPaymentMethod)
    {
        $this->EditPaymentMethod = $EditPaymentMethod;
    }

    /**
     * @return int
     */
    public function getOpinions()
    {
        return $this->Opinions;
    }

    /**
     * @param int $Opinions
     */
    public function setOpinions($Opinions)
    {
        $this->Opinions = $Opinions;
    }

    /**
     * @return int
     */
    public function getEditOpinion()
    {
        return $this->EditOpinion;
    }

    /**
     * @param int $EditOpinion
     */
    public function setEditOpinion($EditOpinion)
    {
        $this->EditOpinion = $EditOpinion;
    }

    /**
     * @return int
     */
    public function getDeleteOpinion()
    {
        return $this->DeleteOpinion;
    }

    /**
     * @param int $DeleteOpinion
     */
    public function setDeleteOpinion($DeleteOpinion)
    {
        $this->DeleteOpinion = $DeleteOpinion;
    }

    /**
     * @return int
     */
    public function getFeeds()
    {
        return $this->Feeds;
    }

    /**
     * @param int $Feeds
     */
    public function setFeeds($Feeds)
    {
        $this->Feeds = $Feeds;
    }

    /**
     * @return int
     */
    public function getInsertFeed()
    {
        return $this->InsertFeed;
    }

    /**
     * @param int $InsertFeed
     */
    public function setInsertFeed($InsertFeed)
    {
        $this->InsertFeed = $InsertFeed;
    }

    /**
     * @return int
     */
    public function getEditFeed()
    {
        return $this->EditFeed;
    }

    /**
     * @param int $EditFeed
     */
    public function setEditFeed($EditFeed)
    {
        $this->EditFeed = $EditFeed;
    }

    /**
     * @return int
     */
    public function getDeleteFeed()
    {
        return $this->DeleteFeed;
    }

    /**
     * @param int $DeleteFeed
     */
    public function setDeleteFeed($DeleteFeed)
    {
        $this->DeleteFeed = $DeleteFeed;
    }

    /**
     * @return int
     */
    public function getFeedSendEmail()
    {
        return $this->FeedSendEmail;
    }

    /**
     * @param int $FeedSendEmail
     */
    public function setFeedSendEmail($FeedSendEmail)
    {
        $this->FeedSendEmail = $FeedSendEmail;
    }

    /**
     * @return int
     */
    public function getGuarantees()
    {
        return $this->Guarantees;
    }

    /**
     * @param int $Guarantees
     */
    public function setGuarantees($Guarantees)
    {
        $this->Guarantees = $Guarantees;
    }

    /**
     * @return int
     */
    public function getInsertGuarantee()
    {
        return $this->InsertGuarantee;
    }

    /**
     * @param int $InsertGuarantee
     */
    public function setInsertGuarantee($InsertGuarantee)
    {
        $this->InsertGuarantee = $InsertGuarantee;
    }

    /**
     * @return int
     */
    public function getEditGuarantee()
    {
        return $this->EditGuarantee;
    }

    /**
     * @param int $EditGuarantee
     */
    public function setEditGuarantee($EditGuarantee)
    {
        $this->EditGuarantee = $EditGuarantee;
    }

    /**
     * @return int
     */
    public function getDeleteGuarantee()
    {
        return $this->DeleteGuarantee;
    }

    /**
     * @param int $DeleteGuarantee
     */
    public function setDeleteGuarantee($DeleteGuarantee)
    {
        $this->DeleteGuarantee = $DeleteGuarantee;
    }

    /**
     * @return int
     */
    public function getColors()
    {
        return $this->Colors;
    }

    /**
     * @param int $Colors
     */
    public function setColors($Colors)
    {
        $this->Colors = $Colors;
    }

    /**
     * @return int
     */
    public function getInsertColor()
    {
        return $this->InsertColor;
    }

    /**
     * @param int $InsertColor
     */
    public function setInsertColor($InsertColor)
    {
        $this->InsertColor = $InsertColor;
    }

    /**
     * @return int
     */
    public function getEditColor()
    {
        return $this->EditColor;
    }

    /**
     * @param int $EditColor
     */
    public function setEditColor($EditColor)
    {
        $this->EditColor = $EditColor;
    }

    /**
     * @return int
     */
    public function getDeleteColor()
    {
        return $this->DeleteColor;
    }

    /**
     * @param int $DeleteColor
     */
    public function setDeleteColor($DeleteColor)
    {
        $this->DeleteColor = $DeleteColor;
    }

    /**
     * @return int
     */
    public function getServices()
    {
        return $this->Services;
    }

    /**
     * @param int $Services
     */
    public function setServices($Services)
    {
        $this->Services = $Services;
    }

    /**
     * @return int
     */
    public function getInsertService()
    {
        return $this->InsertService;
    }

    /**
     * @param int $InsertService
     */
    public function setInsertService($InsertService)
    {
        $this->InsertService = $InsertService;
    }

    /**
     * @return int
     */
    public function getEditService()
    {
        return $this->EditService;
    }

    /**
     * @param int $EditService
     */
    public function setEditService($EditService)
    {
        $this->EditService = $EditService;
    }

    /**
     * @return int
     */
    public function getDeleteService()
    {
        return $this->DeleteService;
    }

    /**
     * @param int $DeleteService
     */
    public function setDeleteService($DeleteService)
    {
        $this->DeleteService = $DeleteService;
    }

    /**
     * @return int
     */
    public function getGroups()
    {
        return $this->Groups;
    }

    /**
     * @param int $Groups
     */
    public function setGroups($Groups)
    {
        $this->Groups = $Groups;
    }

    /**
     * @return int
     */
    public function getInsertGroup()
    {
        return $this->InsertGroup;
    }

    /**
     * @param int $InsertGroup
     */
    public function setInsertGroup($InsertGroup)
    {
        $this->InsertGroup = $InsertGroup;
    }

    /**
     * @return int
     */
    public function getEditGroup()
    {
        return $this->EditGroup;
    }

    /**
     * @param int $EditGroup
     */
    public function setEditGroup($EditGroup)
    {
        $this->EditGroup = $EditGroup;
    }

    /**
     * @return int
     */
    public function getDeleteGroup()
    {
        return $this->DeleteGroup;
    }

    /**
     * @param int $DeleteGroup
     */
    public function setDeleteGroup($DeleteGroup)
    {
        $this->DeleteGroup = $DeleteGroup;
    }

    /**
     * @return int
     */
    public function getSubGroups()
    {
        return $this->SubGroups;
    }

    /**
     * @param int $SubGroups
     */
    public function setSubGroups($SubGroups)
    {
        $this->SubGroups = $SubGroups;
    }

    /**
     * @return int
     */
    public function getInsertSubGroup()
    {
        return $this->InsertSubGroup;
    }

    /**
     * @param int $InsertSubGroup
     */
    public function setInsertSubGroup($InsertSubGroup)
    {
        $this->InsertSubGroup = $InsertSubGroup;
    }

    /**
     * @return int
     */
    public function getEditSubGroup()
    {
        return $this->EditSubGroup;
    }

    /**
     * @param int $EditSubGroup
     */
    public function setEditSubGroup($EditSubGroup)
    {
        $this->EditSubGroup = $EditSubGroup;
    }

    /**
     * @return int
     */
    public function getDeleteSubGroup()
    {
        return $this->DeleteSubGroup;
    }

    /**
     * @param int $DeleteSubGroup
     */
    public function setDeleteSubGroup($DeleteSubGroup)
    {
        $this->DeleteSubGroup = $DeleteSubGroup;
    }

    /**
     * @return int
     */
    public function getSupperGroups()
    {
        return $this->SupperGroups;
    }

    /**
     * @param int $SupperGroups
     */
    public function setSupperGroups($SupperGroups)
    {
        $this->SupperGroups = $SupperGroups;
    }

    /**
     * @return int
     */
    public function getInsertSupperGroup()
    {
        return $this->InsertSupperGroup;
    }

    /**
     * @param int $InsertSupperGroup
     */
    public function setInsertSupperGroup($InsertSupperGroup)
    {
        $this->InsertSupperGroup = $InsertSupperGroup;
    }

    /**
     * @return int
     */
    public function getEditSupperGroup()
    {
        return $this->EditSupperGroup;
    }

    /**
     * @param int $EditSupperGroup
     */
    public function setEditSupperGroup($EditSupperGroup)
    {
        $this->EditSupperGroup = $EditSupperGroup;
    }

    /**
     * @return int
     */
    public function getDeleteSupperGroup()
    {
        return $this->DeleteSupperGroup;
    }

    /**
     * @param int $DeleteSupperGroup
     */
    public function setDeleteSupperGroup($DeleteSupperGroup)
    {
        $this->DeleteSupperGroup = $DeleteSupperGroup;
    }

    /**
     * @return int
     */
    public function getRoles()
    {
        return $this->Roles;
    }

    /**
     * @param int $Roles
     */
    public function setRoles($Roles)
    {
        $this->Roles = $Roles;
    }

    /**
     * @return int
     */
    public function getInsertRole()
    {
        return $this->InsertRole;
    }

    /**
     * @param int $InsertRole
     */
    public function setInsertRole($InsertRole)
    {
        $this->InsertRole = $InsertRole;
    }

    /**
     * @return int
     */
    public function getEditRole()
    {
        return $this->EditRole;
    }

    /**
     * @param int $EditRole
     */
    public function setEditRole($EditRole)
    {
        $this->EditRole = $EditRole;
    }

    /**
     * @return int
     */
    public function getDeleteRole()
    {
        return $this->DeleteRole;
    }

    /**
     * @param int $DeleteRole
     */
    public function setDeleteRole($DeleteRole)
    {
        $this->DeleteRole = $DeleteRole;
    }

    /**
     * @return int
     */
    public function getStats()
    {
        return $this->Stats;
    }

    /**
     * @param int $Stats
     */
    public function setStats($Stats)
    {
        $this->Stats = $Stats;
    }

    /**
     * @return int
     */
    public function getSettings()
    {
        return $this->Settings;
    }

    /**
     * @param int $Settings
     */
    public function setSettings($Settings)
    {
        $this->Settings = $Settings;
    }

    /**
     * @return int
     */
    public function getMenuSettings()
    {
        return $this->MenuSettings;
    }

    /**
     * @param int $MenuSettings
     */
    public function setMenuSettings($MenuSettings)
    {
        $this->MenuSettings = $MenuSettings;
    }

    /**
     * @return int
     */
    public function getColorSettings()
    {
        return $this->ColorSettings;
    }

    /**
     * @param int $ColorSettings
     */
    public function setColorSettings($ColorSettings)
    {
        $this->ColorSettings = $ColorSettings;
    }

    /**
     * @return int
     */
    public function getSendSMS()
    {
        return $this->SendSMS;
    }

    /**
     * @param int $SendSMS
     */
    public function setSendSMS($SendSMS)
    {
        $this->SendSMS = $SendSMS;
    }

    /**
     * @return int
     */
    public function getNews()
    {
        return $this->News;
    }

    /**
     * @param int $News
     */
    public function setNews($News)
    {
        $this->News = $News;
    }

    /**
     * @return int
     */
    public function getInsertNews()
    {
        return $this->InsertNews;
    }

    /**
     * @param int $InsertNews
     */
    public function setInsertNews($InsertNews)
    {
        $this->InsertNews = $InsertNews;
    }

    /**
     * @return int
     */
    public function getEditNews()
    {
        return $this->EditNews;
    }

    /**
     * @param int $EditNews
     */
    public function setEditNews($EditNews)
    {
        $this->EditNews = $EditNews;
    }

    /**
     * @return int
     */
    public function getDeleteNews()
    {
        return $this->DeleteNews;
    }

    /**
     * @param int $DeleteNews
     */
    public function setDeleteNews($DeleteNews)
    {
        $this->DeleteNews = $DeleteNews;
    }

    /**
     * @return int
     */
    public function getNewsApprove()
    {
        return $this->NewsApprove;
    }

    /**
     * @param int $NewsApprove
     */
    public function setNewsApprove($NewsApprove)
    {
        $this->NewsApprove = $NewsApprove;
    }

    /**
     * @return int
     */
    public function getProductApprove()
    {
        return $this->ProductApprove;
    }

    /**
     * @param int $ProductApprove
     */
    public function setProductApprove($ProductApprove)
    {
        $this->ProductApprove = $ProductApprove;
    }

    /**
     * @return int
     */
    public function getSpecialOffers()
    {
        return $this->SpecialOffers;
    }

    /**
     * @param int $SpecialOffers
     */
    public function setSpecialOffers($SpecialOffers)
    {
        $this->SpecialOffers = $SpecialOffers;
    }

    /**
     * @return int
     */
    public function getInsertSpecialOffer()
    {
        return $this->InsertSpecialOffer;
    }

    /**
     * @param int $InsertSpecialOffer
     */
    public function setInsertSpecialOffer($InsertSpecialOffer)
    {
        $this->InsertSpecialOffer = $InsertSpecialOffer;
    }

    /**
     * @return int
     */
    public function getEditSpecialOffer()
    {
        return $this->EditSpecialOffer;
    }

    /**
     * @param int $EditSpecialOffer
     */
    public function setEditSpecialOffer($EditSpecialOffer)
    {
        $this->EditSpecialOffer = $EditSpecialOffer;
    }

    /**
     * @return int
     */
    public function getDeleteSpecialOffer()
    {
        return $this->DeleteSpecialOffer;
    }

    /**
     * @param int $DeleteSpecialOffer
     */
    public function setDeleteSpecialOffer($DeleteSpecialOffer)
    {
        $this->DeleteSpecialOffer = $DeleteSpecialOffer;
    }



    /**
     * Role constructor.
     */
    public function __construct()
    {
        $this->RoleId = 0;
        $this->Name = "";
        $this->Products = 0;
        $this->InsertProduct = 0;
        $this->EditProduct = 0;
        $this->DeleteProduct = 0;
        $this->ProductGroupLimit = 0;
        $this->BrandLimit = 0;
        $this->AllowedProductGroups = "";
        $this->AllowedProductSubGroups = "";
        $this->AllowedProductSupperGroups = "";
        $this->AllowedBrands = "";
        $this->UserCoupons = 0;
        $this->InsertUserCoupon = 0;
        $this->EditUserCoupon = 0;
        $this->DeleteUserCoupon = 0;
        $this->LinkBoxes = 0;
        $this->InsertLinkBox = 0;
        $this->EditLinkBox = 0;
        $this->DeleteLinkBox = 0;
        $this->LinkBoxGroup = 0;
        $this->Users = 0;
        $this->InsertUser = 0;
        $this->EditUser = 0;
        $this->DeleteUser = 0;
        $this->Slides = 0;
        $this->InsertSlide = 0;
        $this->EditSlide = 0;
        $this->DeleteSlide = 0;
        $this->Thumbs = 0;
        $this->InsertThumb = 0;
        $this->EditThumb = 0;
        $this->DeleteThumb = 0;
        $this->ProductCoupons = 0;
        $this->InsertProductCoupon = 0;
        $this->EditProductCoupon = 0;
        $this->DeleteProductCoupon = 0;
        $this->FactorProducts = 0;
        $this->EditFactorProduct = 0;
        $this->Orders = 0;
        $this->EditOrder = 0;
        $this->Panels = 0;
        $this->EditPanel = 0;
        $this->Prices = 0;
        $this->InsertPrice = 0;
        $this->EditPrice = 0;
        $this->DeletePrice = 0;
        $this->PriceChange = 0;
        $this->ShippingMethods = 0;
        $this->InsertShippingMethod = 0;
        $this->EditShippingMethod = 0;
        $this->DeleteShippingMethod = 0;
        $this->Shippings = 0;
        $this->InsertShipping = 0;
        $this->EditShipping = 0;
        $this->DeleteShipping = 0;
        $this->Comments = 0;
        $this->EditComment = 0;
        $this->DeleteComment = 0;
        $this->Discounts = 0;
        $this->EditDiscount = 0;
        $this->DeleteDiscount = 0;
        $this->Brands = 0;
        $this->InsertBrand = 0;
        $this->EditBrand = 0;
        $this->DeleteBrand = 0;
        $this->Customers = 0;
        $this->InsertCustomer = 0;
        $this->EditCustomer = 0;
        $this->DeleteCustomer = 0;
        $this->ProductProperties = 0;
        $this->InsertProductProperty = 0;
        $this->EditProductProperty = 0;
        $this->DeleteProductProperty = 0;
        $this->AllowedProductPropertySubGroups = "";
        $this->PaymentMethods = 0;
//        $this->InsertPaymentMethod = 0;
        $this->EditPaymentMethod = 0;
//        $this->DeletePaymentMethod = 0;
        $this->Opinions = 0;
        $this->EditOpinion = 0;
        $this->DeleteOpinion = 0;
        $this->Feeds = 0;
        $this->InsertFeed = 0;
        $this->EditFeed = 0;
        $this->DeleteFeed = 0;
        $this->FeedSendEmail = 0;
        $this->Guarantees = 0;
        $this->InsertGuarantee = 0;
        $this->EditGuarantee = 0;
        $this->DeleteGuarantee = 0;
        $this->Colors = 0;
        $this->InsertColor = 0;
        $this->EditColor = 0;
        $this->DeleteColor = 0;
        $this->Services = 0;
        $this->InsertService = 0;
        $this->EditService = 0;
        $this->DeleteService = 0;
        $this->Groups = 0;
        $this->InsertGroup = 0;
        $this->EditGroup = 0;
        $this->DeleteGroup = 0;
        $this->SubGroups = 0;
        $this->InsertSubGroup = 0;
        $this->EditSubGroup = 0;
        $this->DeleteSubGroup = 0;
        $this->SupperGroups = 0;
        $this->InsertSupperGroup = 0;
        $this->EditSupperGroup = 0;
        $this->DeleteSupperGroup = 0;
        $this->SupperGroups = 0;
        $this->InsertSupperGroup = 0;
        $this->EditSupperGroup = 0;
        $this->DeleteSupperGroup = 0;
        $this->Roles = 0;
        $this->InsertRole = 0;
        $this->EditRole = 0;
        $this->DeleteRole = 0;
        $this->Stats = 0;
        $this->Settings = 0;
        $this->ColorSettings = 0;
        $this->MenuSettings = 0;
        $this->SendSMS = 0;

        $this->News = 0;
        $this->InsertNews = 0;
        $this->EditNews = 0;
        $this->DeleteNews = 0;
        $this->NewsApprove = 0;
        $this->ProductApprove = 0;

        $this->SpecialOffers = 0;
        $this->InsertSpecialOffer = 0;
        $this->EditSpecialOffer = 0;
        $this->DeleteSpecialOffer = 0;
    }

}