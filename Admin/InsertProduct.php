<?php
require_once 'Template/top2.php';
if (isset($_POST['editmode'])) {
    if ($role->EditProduct != 1) {
        header('Location:Index.php');
        die();
    }
} else {
    if ($role->InsertProduct != 1) {
        header('Location:Index.php');
        die();
    }
}

echo "<br>" . $_POST['productId'] . "<br>" . $_POST["propertyname0"];

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$pds = new ProductDataSource();
$pds->open();

$product = new Product();
$product->ProductId = $_POST['productId'];
$product->Name = $_POST['name'];
//$_POST['content'] = str_replace('<p>', '', $_POST['content']);
if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
    $_POST['review'] = str_replace('/DigitalShopV1/', '', $_POST['review']);
    $_POST['content'] = str_replace('/DigitalShopV1/', '', $_POST['content']);
    $_POST['downloadcontent'] = str_replace('/DigitalShopV1/', '', $_POST['downloadcontent']);

    $_POST['review'] = str_replace('../', '', $_POST['review']);
    $_POST['content'] = str_replace('../', '', $_POST['content']);
    $_POST['downloadcontent'] = str_replace('../', '', $_POST['downloadcontent']);
} else {
    $_POST['review'] = str_replace('http://', '', $_POST['review']);
    $_POST['content'] = str_replace('http://', '', $_POST['content']);
    $_POST['downloadcontent'] = str_replace('http://', '', $_POST['downloadcontent']);
}
$product->Review = $pds->mres($_POST['review']);
$product->Description = $pds->mres($_POST['content']);
$product->DownloadContent= $pds->mres($_POST['downloadcontent']);

//$_POST['content'] = str_replace('</p>', '', $_POST['content']);
$product->User = $_POST['user'];
$product->LatinName = $_POST['latinname'];
$product->Brand = $_POST['brand'];

if (isset($_POST['stock']) == true) {
    $product->Stock = 1;
} else {
    $product->Stock = 0;
}

if (isset($_POST['downloadable']) == true) {
    $product->Downloadable = 1;
} else {
    $product->Downloadable= 0;
}

//$_POST['review'] = str_replace('<p>', '', $_POST['review']);
//$_POST['review'] = str_replace('</p>', '', $_POST['review']);



$product->Activated = $_POST['activated'];

$product->Group = $_POST['group'];
$product->SubGroup = $_POST['subgroup'];
$product->SupperGroup = $_POST['suppergroup'];

$_POST['image'] = str_replace('/DigitalShopV1/Images', 'Images', $_POST['image']);
$product->Image = $_POST['image'];

$product->Keywords = $_POST['keywords'];
$product->MetaDescription = $_POST['metadescription'];


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$prds = new PriceDataSource();
$prds->open();
$price = new Price();
$price->Date = date("Y/m/d");
$price->Product = $_POST['productId'];
$price->User = $_POST['user'];
$_POST['price'] = str_replace(',', '', $_POST['price']);
$lastPrice = $prds->GetLastPriceForOneProduct($_POST['productId']);
$price->Value = $_POST['price'];
if ($lastPrice != $_POST['price']) {
    $prds->Insert($price);
}
$prds->close();


if (trim($_POST['coupon'] != "")) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
    $pcds = new ProductCouponDataSource();
    $pcds->open();

    $productcoupon = new ProductCoupon();
    if ($pcds->FindOneProductCoupons2($_POST['productId']) != NULL) {
        $productLastCoupon = $pcds->FindOneProductCoupons2($_POST['productId']);
        $productcoupon2 = $pcds->GetLastProductCouponsForOneProductInfo($_POST['productId']);
        if ($productLastCoupon != $_POST['coupon']) {
            $pcds->Delete($productcoupon2->ProductCouponId);
        }
    }
    $productcoupon->Date = date("Y/m/d");
    $productcoupon->Product = $_POST['productId'];
    $productcoupon->User = $_POST['user'];
    $productcoupon->Value = $_POST['coupon'];
    if ($productLastCoupon != $_POST['coupon']) {
        $pcds->Insert($productcoupon);
    }

    $pcds->close();
}

if (trim($_POST['discount'] != "")) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
    $dcds = new DiscountDataSource();
    $dcds->open();
    $discount = new Discount();
    if ($dcds->GetLastDiscountForOneProduct($_POST['productId']) != NULL) {
        $productLastDiscount = $dcds->GetLastDiscountForOneProduct($_POST['productId']);
        $discount2 = $dcds->GetLastDiscountForOneProductInfo($_POST['productId']);
        if ($productLastDiscount != $_POST['discount']) {
            $dcds->Delete($discount2->DiscountId);
        }
    }
    $discount->Product = $_POST['productId'];
    $discount->User = $_POST['user'];
    $discount->Value = $_POST['discount'];
    if ($productLastDiscount != $_POST['discount']) {
        $dcds->Insert($discount);
    }
    $dcds->close();
}


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

//echo "saddasdsadasd";

$papds = new ProductAndPropertyDataSource();
$papds->open();
$productAndProperty = new  ProductAndProperty();
$productAndProperty->Product = $_POST['productId'];

for ($i = 0; isset($_POST["property$i"]); $i++) {
    if (trim($_POST["property$i"]) != "") {
        if ($papds->doesPPExist(intval($_POST["propertyname$i"]), $_POST['productId']) != 0) {
            $productAndProperty2 = new ProductAndProperty();
            $productAndProperty2->ProductAndPropertyId = $papds->doesPPExist(intval($_POST["propertyname$i"]), $_POST['productId']);
            $productAndProperty2->ProductProperty->ProductPropertyId = intval($_POST["propertyname$i"]);
            $productAndProperty2->Product = $_POST['productId'];
            $productAndProperty2->Value = $_POST["property$i"];
            $papds->Update($productAndProperty2);

        } else {
            $productAndProperty->ProductProperty->ProductPropertyId = intval($_POST["propertyname$i"]);
            $productAndProperty->Value = $_POST["property$i"];
            $papds->Insert($productAndProperty);
        }
    } else {
        if ($papds->doesPPExist(intval($_POST["propertyname$i"]), $_POST['productId']) != 0) {
            $productAndProperty2 = new ProductAndProperty();
            $productAndProperty2->ProductAndPropertyId = $papds->doesPPExist(intval($_POST["propertyname$i"]),$_POST['productId']);
            $papds->Delete($productAndProperty2->ProductAndPropertyId);
        }
    }
}
$papds->close();

$pds->FillTheBlank($product);
header('Location:Products.php');
