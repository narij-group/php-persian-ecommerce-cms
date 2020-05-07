<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
//require_once '../includes/DbOperation.php';

//Creating a new app with the config to show errors
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

//function to check parameters
function isTheseParametersAvailable($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echo json_encode($response);
        return false;
    }
    return true;
}

$app->get("/getBrands", function (Request $request, Response $response) {
    require_once "../../Classes/Logo.inc";
    $logo = new Logo();
    $logos = $logo->Fill();
    $temps = array();
    foreach ($logos as $u) {
        $temp = array();
        $temp["id"] = $u->LogoId;
        $temp["property1"] = $u->Name;
        $temp["property2"] = $u->LatinName;
        array_push($temps, $temp);
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));
});

$app->get("/getSiteInfo", function (Request $request, Response $response) {
    require_once '../../Classes/Settings.inc';
    $setting = new Settings();
    $settings = $setting->Fill();
    $temps = array();
    $temp = array();
    $temp["id"] = 1;
    $temp["property1"] = $settings->Email;
    $temp["property2"] = $settings->SiteName;
    array_push($temps, $temp);
    $response->getBody()->write(json_encode(array("temps" => $temps)));
});

$app->get("/getSpecialOfferProducts", function (Request $request, Response $response) {
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
        $temp["discount"] = "";
        if ($price->GetLastPriceForOneProduct($p->Product->ProductId) != $price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $d->GetLastDiscountForOneProduct($p->Product->ProductId) / 100)) {
            $temp["discount"] = number_format($price->GetLastPriceForOneProduct($p->Product->ProductId) * $tax) . " تومان";
        }
        $temp["name"] = $p->Product->Name;
        $temp["latinname"] = $p->Product->LatinName;
        $temp["image"] = $p->Product->Image;
        $temp["price"] = number_format(($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $d->GetLastDiscountForOneProduct($p->Product->ProductId) / 100)) * $tax) . " تومان";
        array_push($products, $temp);
    }
    $response->getBody()->write(json_encode(array("products" => $products)));
});

$app->get("/getLatestProducts", function (Request $request, Response $response) {
    require_once '../../Classes/Settings.inc';
    $setting = new Settings();
    $settings = $setting->Fill();
    if ($settings->Tax != 0) {
        $tax = (100 + $settings->Tax) / 100;
    } else {
        $tax = 1;
    }

    require_once '../../Classes/Product.inc';
    require_once "../../Classes/Price.inc";
    require_once "../../Classes/Discount.inc";
    $p = new Product();
    $price = new Price();
    $d = new Discount();
    $products = array();
    $products2 = $p->FillIfExists();
    foreach ($products2 as $p) {
        $temp = array();
        $temp["productId"] = $p->ProductId;
        $temp["discount"] = "";
        if ($price->GetLastPriceForOneProduct($p->ProductId) != $price->GetLastPriceForOneProduct($p->ProductId) - ($price->GetLastPriceForOneProduct($p->ProductId) * $d->GetLastDiscountForOneProduct($p->ProductId) / 100)) {
            $temp["discount"] = number_format($price->GetLastPriceForOneProduct($p->ProductId) * $tax) . " تومان";
        }
        $temp["name"] = $p->Name;
        $temp["latinname"] = $p->LatinName;
        $temp["image"] = $p->Image;
        $temp["price"] = number_format(($price->GetLastPriceForOneProduct($p->ProductId) - ($price->GetLastPriceForOneProduct($p->ProductId) * $d->GetLastDiscountForOneProduct($p->ProductId) / 100)) * $tax) . " تومان";
        array_push($products, $temp);
    }
    $response->getBody()->write(json_encode(array("products" => $products)));
});

$app->post("/getOneProduct", function (Request $request, Response $response) {

    $requestData = $request->getParsedBody();

    require_once '../../Classes/Settings.inc';
    $setting = new Settings();
    $settings = $setting->Fill();
    if ($settings->Tax != 0) {
        $tax = (100 + $settings->Tax) / 100;
    } else {
        $tax = 1;
    }


    require_once '../../Classes/Product.inc';
    require_once "../../Classes/Price.inc";
    require_once "../../Classes/Discount.inc";
    $p2 = new Product();
    $price = new Price();
    $d = new Discount();

    $p2->ProductId = $requestData['product_id'];

    $p = $p2->FindOneProduct();

    $temp["productId"] = $p->ProductId;
    $temp["discount"] = "";
    if ($price->GetLastPriceForOneProduct($p->ProductId) != $price->GetLastPriceForOneProduct($p->ProductId) - ($price->GetLastPriceForOneProduct($p->ProductId) * $d->GetLastDiscountForOneProduct($p->ProductId) / 100)) {
        $temp["discount"] = number_format($price->GetLastPriceForOneProduct($p->ProductId) * $tax) . " تومان";
    }
    $temp["name"] = $p->Name;
    $temp["latinname"] = $p->LatinName;
    $temp["image"] = $p->Image;
    $temp["comment"] = $p->Description;
    $temp["price"] = number_format(($price->GetLastPriceForOneProduct($p->ProductId) - ($price->GetLastPriceForOneProduct($p->ProductId) * $d->GetLastDiscountForOneProduct($p->ProductId) / 100)) * $tax) . " تومان";
    $temps = array();
    array_push($temps, $temp);


    $response->getBody()->write(json_encode(array("products" => $temps)));
});

//$app->get("/getHumen", function (Request $request, Response $response) {
//    $humen  = array();
//    $names = array("ali", "reza", "ahmad", "taghi", "amir");
//    $families = array("alinia", "rezaei", "ahmad pour", "taghi zadeh", "amiri nia");
//    for ($i = 1; $i <= 10; $i++) {
//        //$h = new Human();
//        $human= array();
//        $human["humanId"]= $i;
//        $human["name"]= $names[rand(0, count($names)-1)];
//        $human["family"]= $families[rand(0, count($families)-1)];
//        array_push($humen, $human);
//    }
//    $response->getBody()->write(json_encode(array("humen" => $humen)));
//});


$app->get("/getSlides", function (Request $request, Response $response) {
    require_once '../../Classes/Slide.inc';
    $slide = new Slide();
    $slides = $slide->Fill();

    $a = 0;
    $array_slide = array();
    foreach ($slides as $s) {
        $array_slide[$a] = $s->SlideId;
        $a++;
    }
    shuffle($array_slide);
    $temps = array();
    $i = 1;
    foreach ($array_slide as $j) {
        if ($i <= 5) {
            $temp = array();
            $slide2 = new Slide();
            $slide2->SlideId = $j;
            $ss = $slide2->FindOneSlide();
            $temp["id"] = $ss->SlideId;
            $temp["property1"] = $ss->Image;
            $temp["property2"] = $ss->Link;
            array_push($temps, $temp);
            $i++;
        }
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));
});

$app->get("/getColors", function (Request $request, Response $response) {
    require_once "../../Classes/ColorList.inc";
    $clist = new ColorList();
    $clists = $clist->Fill();
    $temps = array();
    foreach ($clists as $u) {
        $temp = array();
        $temp["id"] = $u->ColorListId;
        $temp["property1"] = $u->Name;
        $temp["property2"] = "";
        array_push($temps, $temp);
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));
});


$app->post("/getGroups", function (Request $request, Response $response) {
    $requestData = $request->getParsedBody();
    $userid = $requestData['userid'];
    include_once '../../Classes/User.inc';
    $u1 = new User();
    $u1->UserId = $userid;
    $user1 = $u1->FindOneUser();

    include_once '../../Classes/Role.inc';
    $r = new Role();
    $r->RoleId = $user1->Role;
    $role = $r->FindOneRole();

    require_once "../../Classes/Group.inc";
    $group = new Group();
    $groups = $group->Fill();
    $temps = explode(',', $role->AllowedProductGroups);
    $i = 0;
    $Groups = array();
    foreach ($temps as $t) {
        if (trim($t) != "") {
            $Groups[$i] = $t;
            $i++;
        }
    }
    $temps = array();

    if ($role->ProductGroupLimit == 1) {
        foreach ($groups as $u) {
            if (in_array($u->GroupId, $Groups)) {
                $temp = array();
                $temp["id"] = $u->GroupId;
                $temp["property1"] = $u->Name;
                $temp["property2"] = $u->LatinName;
                array_push($temps, $temp);
            }
        }
    } else {
        foreach ($groups as $u) {
            $temp = array();
            $temp["id"] = $u->GroupId;
            $temp["property1"] = $u->Name;
            $temp["property2"] = $u->LatinName;
            array_push($temps, $temp);
        }
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));

});


$app->post("/getSubGroups", function (Request $request, Response $response) {

    $requestData = $request->getParsedBody();
    $userid = $requestData['userid'];
    include_once '../../Classes/User.inc';
    $u1 = new User();
    $u1->UserId = $userid;
    $user1 = $u1->FindOneUser();

    include_once '../../Classes/Role.inc';
    $r = new Role();
    $r->RoleId = $user1->Role;
    $role = $r->FindOneRole();


    require_once "../../Classes/SubGroup.inc";
    $subgroup = new SubGroup();
    $subgroups = $subgroup->Fill();
    $temps = explode(',', $role->AllowedProductSubGroups);
    $i = 0;
    $SubGroups = array();
    foreach ($temps as $t) {
        if (trim($t) != "") {
            $SubGroups[$i] = $t;
            $i++;
        }
    }

    $temps = array();
    if ($role->ProductGroupLimit == 1) {
        foreach ($subgroups as $u) {
            if (in_array($u->SubGroupId, $SubGroups)) {
                $temp = array();
                $temp["id"] = $u->SubGroupId;
                $temp["property1"] = $u->Name;
                $temp["property2"] = $u->LatinName;
                array_push($temps, $temp);
            }
        }
    } else {
        foreach ($subgroups as $u) {
            $temp = array();
            $temp["id"] = $u->SubGroupId;
            $temp["property1"] = $u->Name;
            $temp["property2"] = $u->LatinName;
            array_push($temps, $temp);
        }
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));

});


$app->post("/getSupperGroups", function (Request $request, Response $response) {

    $requestData = $request->getParsedBody();
    $userid = $requestData['userid'];
    include_once '../../Classes/User.inc';
    $u1 = new User();
    $u1->UserId = $userid;
    $user1 = $u1->FindOneUser();

    include_once '../../Classes/Role.inc';
    $r = new Role();
    $r->RoleId = $user1->Role;
    $role = $r->FindOneRole();


    require_once "../../Classes/SupperGroup.inc";
    $suppergroup = new SupperGroup();
    $suppergroups = $suppergroup->Fill();
    $temps = explode(',', $role->AllowedProductSupperGroups);
    $i = 0;
    $SupperGroups = array();
    foreach ($temps as $t) {
        if (trim($t) != "") {
            $SupperGroups[$i] = $t;
            $i++;
        }
    }

    $temps = array();
    if ($role->ProductGroupLimit == 1) {
        foreach ($suppergroups as $u) {
            if (in_array($u->SupperGroupId, $SupperGroups)) {
                $temp = array();
                $temp["id"] = $u->SupperGroupId;
                $temp["property1"] = $u->Name;
                $temp["property2"] = $u->LatinName;
                array_push($temps, $temp);
            }
        }
    } else {
        foreach ($suppergroups as $u) {
            $temp = array();
            $temp["id"] = $u->SupperGroupId;
            $temp["property1"] = $u->Name;
            $temp["property2"] = $u->LatinName;
            array_push($temps, $temp);
        }
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));

});


$app->get("/insertBlankProduct", function (Request $request, Response $response) {
    require_once "../../Classes/Product.inc";

    $product = new Product();
//    $product->User = time();
    $id = $product->InsertBlank();
    //$id = $product->MaxId();

    if (file_exists("../../Images/$id") == false) {
        mkdir("../../Images/$id");
    }

    $responseData['error'] = false;
    $responseData['message'] = $id;
    $response->getBody()->write(json_encode($responseData));

});


//user login route
$app->post('/login', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('email', 'password'))) {
        $requestData = $request->getParsedBody();
        $email = $requestData['email'];
        $password = $requestData['password'];

        require_once "../../Classes/User.inc";
        $user = new User();
        $user->Username = $email;
        $user->Password = md5($password);
        if ($user->IsUserAllowed2()) {
            $responseData['error'] = false;
            $responseData['message'] = $user->GetUserId();
            $response->getBody()->write(json_encode($responseData));
        } else {
            $responseData['error'] = true;
            $responseData['message'] = 'نام کاربری یا رمزعبور اشتباه است!';
            $response->getBody()->write(json_encode($responseData));
        }
    }
});


$app->post('/getProductImages', function (Request $request, Response $response) {

    $requestData = $request->getParsedBody();

    $dir = "../../Images/" . $requestData['product_id'];
    $files = array_values(array_filter(scandir($dir), function ($file) {
        return !is_dir($file);
    }));
    $temps = array();
    $i = 0;
    foreach ($files as $file) {
        if (strpos($file, 'png') !== false || strpos($file, 'jpg') !== false) {
            $temp = array();
            $temp["id"] = $i;
            $temp["property1"] = "Images/" . $requestData['product_id'] . "/$file";
            $temp["property2"] = "Slide" + $i;
            array_push($temps, $temp);
            $i++;
        }
    }
    if ($temps == null) {
        $temp = array();
        $temp["id"] = $i;
        $temp["property1"] = $dir;
        $temp["property2"] = "OH SHIT";
        array_push($temps, $temp);
        $i++;
    }
    $response->getBody()->write(json_encode(array("temps" => $temps)));
});


$app->post('/insertProduct', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('productid', 'name', 'latinname', 'price', 'brand', 'group', 'subgroup', 'suppergroup', 'user'))) {
        $requestData = $request->getParsedBody();

        require_once "../../Classes/Product.inc";
        $product = new Product();
        $product->ProductId = $requestData['productid'];
        $product->Name = $requestData['name'];
        $product->LatinName = $requestData['latinname'];

        require_once "../../Classes/Logo.inc";
        $logo = new Logo();
        $logos = $logo->Fill();
        foreach ($logos as $l) {
            if (strpos($requestData['brand'], $l->Name) !== false) {
                $product->Brand = $l->LogoId;
            }
        }

        require_once "../../Classes/Group.inc";
        $gp = new Group();
        $gps = $gp->Fill();
        $product->Group = 1;
        foreach ($gps as $l) {
            if (strpos($requestData['group'], $l->Name) !== false) {
                $product->Group = $l->GroupId;
            }
        }

        require_once "../../Classes/SubGroup.inc";
        $sgp = new SubGroup();
        $sgps = $sgp->Fill();
        $product->SubGroup = 1;
        foreach ($sgps as $l) {
            if (strpos($requestData['subgroup'], $l->Name) !== false) {
                $product->SubGroup = $l->SubGroupId;
            }
        }

        require_once "../../Classes/SupperGroup.inc";
        $ssgp = new SupperGroup();
        $ssgps = $ssgp->Fill();
        $product->SupperGroup = 1;
        foreach ($ssgps as $l) {
            if (strpos($requestData['suppergroup'], $l->Name) !== false) {
                $product->SupperGroup = $l->SupperGroupId;
            }
        }

        $product->User = $requestData['user'];
        $files = scandir("../../Images/" . $requestData['productid']);
        $i = 0;
        while ($files) {
            if (strpos($files[$i], ".jpg") !== false || strpos($files[$i], ".png") !== false || strpos($files[$i], ".jpeg") !== false) {
                $product->Image = "Images/" . $requestData['productid'] . "/" . $files[$i];
                break;
            } else {
                if ($i > 10) {
                    break;
                }
                $i++;
            }
        }
        $ss = $product->AppInsert();
        //------PRICE------//
        require_once '../../Classes/Price.inc';
        $price = new Price();
        $price->Date = date("Y/m/d");
        $price->Product = $requestData['productid'];
        $price->User = $requestData['user'];
        $lastPrice = $price->GetLastPriceForOneProduct($requestData['productid']);
        $price->Value = $requestData['price'];
        if ($lastPrice != $requestData['price']) {
            $price->Insert();
        }


        $responseData['error'] = false;
        $responseData['message'] = $ss;
        //$product->AppInsert();
        $response->getBody()->write(json_encode($responseData));

    } else {
        $responseData['error'] = true;
        $responseData['message'] = 'مشکلی به وجود آمد! لطفا دوباره امتحان کنید.';
        $response->getBody()->write(json_encode($responseData));
    }
});


$app->post('/register', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('name', 'family', 'nationality_code', 'email', 'username', 'password', 'mobile', 'phone'))) {
        $requestData = $request->getParsedBody();

        require_once '../../Classes/Customer.inc';
        $customer = new Customer();
        $customer->Name = $requestData['name'];
        $customer->Family = $requestData['family'];
        $customer->Password = md5($requestData['password']);
        $customer->Email = $requestData['email'];
        $customer->Phone = $requestData['phone'];
        $customer->Username = $requestData['username'];
        $customer->Mobile = $requestData['mobile'];
        $customer->NationalityCode = $requestData['nationality_code'];
        $message = "";
        if ($customer->IsEmailAllowed() == 1) {

        } else {
            $message = "UsernameE()";
            $responseData['error'] = true;
            $responseData['message'] = 'این پست الکترونیک قبلا استفاده شده است!';
        }
        if ($customer->IsNCodeAllowed() == 1) {

        } else {
            $message = "UsernameE()";
            $responseData['error'] = true;
            $responseData['message'] = 'این کد ملی قبلا استفاده شده است!';
        }
        if ($customer->IsUsernameAllowed() == 1) {

        } else {
            $message = "UsernameE()";
            $responseData['error'] = true;
            $responseData['message'] = 'این نام کاربری قبلا استفاده شده است!';
        }
        if ($message == "" && $requestData['username'] != "admin") {
            $customer->Insert();
            $responseData['error'] = false;
            $responseData['message'] = 'موفق';
        }

        $response->getBody()->write(json_encode($responseData));
    } else {
        $responseData['error'] = true;
        $responseData['message'] = 'مشکلی به وجود آمد! لطفا دوباره امتحان کنید.';
        $response->getBody()->write(json_encode($responseData));
    }
});

$app->post('/insertColor', function (Request $request, Response $response) {
    if (isTheseParametersAvailable(array('productid', 'colorname', 'quantity'))) {
        $requestData = $request->getParsedBody();

        require_once '../../Classes/ProductColor.inc';
        $productcolor = new ProductColor();

        $color = new ProductColor();


        require_once '../../Classes/ColorList.inc';
        $colorlist = new ColorList();
        $colorid = $colorlist->FindOneColorId($requestData['colorname']);


        $productcolor2 = $color->FindColor($requestData['productid'], $colorid);
        if ($productcolor2 == null) {
            $productcolor->Product = $requestData['productid'];
            $productcolor->Color = $colorid;
            $productcolor->Quantity = $requestData['quantity'];
            $productcolor->Insert();
        } else {
            $productcolor2->Quantity = $requestData['quantity'];
            $productcolor2->Update();
        }


        $responseData['error'] = false;
        $responseData['message'] = "موفق";
        $response->getBody()->write(json_encode($responseData));

    } else {
        $responseData['error'] = true;
        $responseData['message'] = 'مشکلی به وجود آمد! لطفا دوباره امتحان کنید.';
        $response->getBody()->write(json_encode($responseData));
    }
});

$app->run();