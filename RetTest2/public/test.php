<meta charset="UTF-8">
<?php
require_once '../../Classes/Settings.inc';
$setting = new Settings();
$settings = $setting->Fill();
if ($settings->Tax != 0) {
    $tax = (100 + $settings->Tax) / 100;
} else {
    $tax = 1;
}

require_once "../../Classes/Price.inc";
require_once "../../Classes/Discount.inc";
$price = new Price();
$d = new Discount();
$products2 = $d->FindSpecialOffers2();
$products = array();
foreach ($products2 as $p) {
    $temp = array();
    $temp["productId"] = $p->Product->ProductId;
    $temp["name"] = $p->Product->Name;
    $temp["latinname"] = $p->Product->LatinName;
    $temp["discount"] = "";
    if ($price->GetLastPriceForOneProduct($p->Product->ProductId) != $price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $d->GetLastDiscountForOneProduct($p->Product->ProductId) / 100)) {
        $temp["discount"] = number_format($price->GetLastPriceForOneProduct($p->Product->ProductId) * $tax) . " تومان";
    }
    $temp["price"] = number_format(($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $d->GetLastDiscountForOneProduct($p->Product->ProductId) / 100) ) * $tax ) . " تومان" ;
    $temp["image"] = $p->Product->Image;
    array_push($products, $temp);
}
echo json_encode(array("products" => $products));