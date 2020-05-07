<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Product.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "PriceDataSource.inc";


class ProductDataSource implements JsonSerializable
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

    public function InsertBlank()
    {
        $SQL = "Insert Into products(Name,Activated) Values ('Empty',0)";
        return $this->da->exec($SQL);
    }

    public function FindEmptyProducts()
    {
        $SQL = "Select products.ProductId from products where name = 'Empty'";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $products[] = $row['ProductId'];
        }
        return $products;
    }

    public function Activate($id)
    {
        $SQL = "Update products Set Activated = 1 Where ProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function Deactivate($id)
    {
        $SQL = "Update products Set Activated = 0 Where ProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function MoveTo($id, $group, $subgroup, $suppergroup)
    {
        $SQL = "Update products Set `Group` = " . $group . " , SubGroup = " . $subgroup . " , SupperGroup = " . $suppergroup . " Where ProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function FillTheBlank(Product $product)
    {
        $SQL = "Update products Set `Name`='" . $product->getName() . "',`LatinName`='" . $product->getLatinName() . "',Description='" . $product->getDescription() . "' , User = " . $product->getUser() . " , Review = '" . $product->getReview() . "' , Brand =" . $product->getBrand() . " , Image = '" . $product->getImage() . "' , Activated=" . $product->getActivated() . " , Keywords = '" . $product->getKeywords() . "' , MetaDescription = '" . $product->getMetaDescription() . "',`Group` = " . $product->getGroup() . ",SubGroup = " . $product->getSubGroup() . " , SupperGroup = " . $product->getSupperGroup() . " , Stock = " . $product->getStock() . " , Downloadable = " . $product->getDownloadable() . " , DownloadContent = '" . $product->getDownloadContent()  . "' Where ProductId=" . $product->getProductId() . "";
        $this->da->exec($SQL);
    }

    public function AppInsert(Product $product)
    {
        $SQL = "Update products Set `Name`='" . $product->getName() . "',`LatinName`='" . $product->getLatinName() . "',User = " . $product->getUser() . " , Brand =" . $product->getBrand() . " , Activated = 0 ,`Group` = " . $product->getGroup() . ", Image = '" . $product->getImage() . "',SubGroup = " . $product->getSubGroup() . " , SupperGroup = " . $product->getSupperGroup() . " Where ProductId=" . $product->getProductId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {


        $SQL = "Delete From products Where ProductId= " . $id;
        $this->da->exec($SQL);
    }

    public function K_Delete($id)
    {
        $this->DeleteFolder("../Images/{$id}");

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'PriceDataSource.inc';
        $prds = new PriceDataSource();
        $prds->open();
        $prds->DeletePricesRelatedToProduct($id);
        $prds->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'PurchaseBasketDataSource.inc';
        $pbds = new PurchaseBasketDataSource();
        $pbds->open();
        $pbds->DeletePurchaseBasketsRelatedToProducts($id);
        $pbds->close();

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'GuaranteeDataSource.inc';
        $grds = new GuaranteeDataSource();
        $grds->open();
        $grds->DeleteGuaranteesRelatedToProduct($id);
        $grds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductColorDataSource.inc';
        $pcds = new ProductColorDataSource();
        $pcds->open();
        $pcds->DeleteProductColorsRelatedToProduct($id);
        $pcds->close();
//$pCoupons = $pCoupon->FindOneProductCoupons($product->ProductId);
//foreach ($pCoupons as $pcc) {
//    $pcc->Delete();
//}

        require_once __DIR__ . DIRECTORY_SEPARATOR . 'StatDataSource.inc';
        $stds = new StatDataSource();
        $stds->open();
        $stds->DeleteStatsRelatedToProduct($id);
        $stds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'MenuDataSource.inc';
        $mnds = new MenuDataSource();
        $mnds->open();
        $mnds->DeleteMenusRelatedToProduct($id);
        $mnds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'OpinionDataSource.inc';
        $opds = new OpinionDataSource();
        $opds->open();
        $opds->DeleteOpinionsRelatedToProduct($id);
        $opds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'CommentDataSource.inc';
        $cmds = new CommentDataSource();
        $cmds->open();
        $cmds->DeleteCommentsRelatedToProduct($id);
        $cmds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'DiscountDataSource.inc';
        $dsds = new DiscountDataSource();
        $dsds->open();
        $dsds->DeleteDiscountsRelatedToProduct($id);
        $dsds->close();


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductAndPropertyDataSource.inc';
        $ppds = new ProductAndPropertyDataSource();
        $ppds->open();
        $ppds->DeletePropertiesRelatedToProduct($id);
        $ppds->close();

        $SQL = "Delete From products Where ProductId= " . $id;
        $this->da->exec($SQL);
    }

    function DeleteFolder($path)
    {
        if (is_dir($path) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if (in_array($file->getBasename(), array('.', '..')) !== true) {
                    if ($file->isDir() === true) {
                        rmdir($file->getPathName());
                    } else if (($file->isFile() === true) || ($file->isLink() === true)) {
                        unlink($file->getPathname());
                    }
                }
            }
            return rmdir($path);
        } else if ((is_file($path) === true) || (is_link($path) === true)) {
            return unlink($path);
        }

        return false;
    }

    public function FindOneProductBasedOnId($id, $get_prices = false, $get_opinions = false, $get_properties = false)
    {
        $SQL = "Select products.ProductId ,  products.Stock , products.Downloadable , products.DownloadContent, products.Name ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells  ,(Select Sum(Visit) from stats where Product = products.ProductId) as Visits, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId Where ProductId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);

            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setName($row['Name']);
            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Name2']);
            $product->getUser()->setFamily($row['Price']);

            $product->Family = $row['Family'];

            $product->getUser()->setUsername($row['Quantity']);
            $product->getUser()->setPassword($row['Discount']);

            $product->SpecialOffer = $row['SO'];

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);
            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);

            $product->Visits = $row['Visits'];
            $product->Sells = $row['Sells'];


            if ($get_prices == true) {
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'PriceDataSource.inc';
                $prds = new PriceDataSource();
                $prds->open();
                $product->Prices = $prds->GetPricesForOneProduct($row['ProductId']);
                $prds->close();
            }

            if ($get_opinions == true) {
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'OpinionDataSource.inc';
                $ods = new OpinionDataSource();
                $ods->open();
                $product->Opinions = $ods->GetOpinionsForProduct($row['ProductId']);
                $ods->close();
            }


            if ($get_properties == true) {
                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductAndPropertyDataSource.inc';
            }

            return $product;
        }
    }

    public function FindOneProductBasedOnId2($id)
    {
        $SQL = "Select User from products where ProductId = $id ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
//            $product->Name = $row['Name'];
//            $product->LatinName = $row['LatinName'];
            $product->User = $row['User'];
            return $product;
        }
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
        // TODO: Implement jsonSerialize() method.
    }

    public function FindOneProductImage(Product $product)
    {
        $SQL = "Select Image From products Where ProductId=" . $product->getProductId();
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            echo $row['Image'];
        }
    }

    public function Fill()
    {
        $SQL = "Select products.ProductId , products.Name ,products.Stock ,  products.Downloadable , products.DownloadContent, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId ORDER BY ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setStock($row['Stock']);


            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);



            $product->setName($row['Name']);
            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function CAdvancedFill($query, $order, $ordertype)
    {
        $SQL = "Select products.ProductId, products.Stock, products.Downloadable , products.DownloadContent ,IFNULL((Select Sum(Visit) from stats where Product = products.ProductId),0) as Visits , products.Name ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Name ,IFNULL((Select Rate from opinions where ProductId = products.ProductId),0) as Popularity , (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId ORDER BY SpecialOfferId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity, products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 $query ORDER BY Quantity = 0 , $order $ordertype";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);

            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);


            $product->setLatinName($row['LatinName']);
            $product->setImage($row['Image']);


            $product->Sells = $row['Sells'];
            $product->SpecialOffer = $row['SO'];


            $product->Price = $row['Price'];


            $product->getUser()->setUsername($row['Quantity']);

            $product->getUser()->setPassword($row['Discount']);


            $product->getGroup()->setGroupId($row['GroupId']);

            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function FillBySG($subgroupid)
    {
        $SQL = "Select ProductId,Activated,SubGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND SubGroup = $subgroupid ORDER BY Quantity =0, ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $products[] = $row['ProductId'];
        }
        return $products;
    }

    public function FillBySG2($subgroupid)
    {
        $SQL = "Select ProductId,Activated,SubGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND SubGroup = $subgroupid ORDER BY ProductId DESC Limit 16";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $products[] = $row['ProductId'];
        }
        return $products;
    }

    public function FillByG($groupid)
    {
        $SQL = "Select ProductId,Activated,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND `Group` = $groupid ORDER BY Quantity =0, ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $products[] = $row['ProductId'];
        }
        return $products;
    }

    public function FillByGroup($groupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `Group` = $groupid ORDER BY ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[] = $product;
        }
        return $products;
    }

    public function GetThisUserProducts($user)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `User` = $user ORDER BY ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[] = $product;
        }
        return $products;
    }

    public function FillBySGroup($sgroupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `SubGroup` = $sgroupid ORDER BY ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[] = $product;
        }
        return $products;
    }

    public function FillBySSGroup($ssgroupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `SupperGroup` = $ssgroupid ORDER BY ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[] = $product;
        }
        return $products;
    }

    public function FillBySPG($suppergroupid)
    {
        $SQL = "Select ProductId,Activated,SupperGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND SupperGroup = $suppergroupid ORDER BY Quantity =0, ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $products[] = $row['ProductId'];
        }
        return $products;
    }

    public function FillDependOnSells2()
    {
        $SQL = "Select products.ProductId , products.Name  , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , logos.LatinName as BLName,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells ,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND products.Activated = 1  AND (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 ORDER BY Sells DESC Limit 16";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setImage($row['Image']);
            $products[] = $product;
        }
        return $products;
    }

    public function FillIfExists()
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Downloadable , products.DownloadContent, products.Name ,logos.LogoId,logos.Name as BName , logos.LatinName as BLName , IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity ,  products.Review , products.LatinName , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND products.Activated = 1 ORDER BY ProductId DESC Limit 16";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->Stock = $row['Stock'];
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->LatinName = $row['LatinName'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Keywords = $row['Keywords'];
            $product->Review = $row['Review'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['UserId'];
            $product->User->Name = $row['Name2'];
            $product->User->Family = $row['Family'];
            $product->User->Username = $row['Username'];
            $products[] = $product;
        }
        return $products;
    }

    public function CFill($order, $ordertype)
    {
        $SQL = "Select products.ProductId,products.Stock , products.Downloadable , products.DownloadContent ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Name ,IFNULL((Select Rate from opinions where ProductId = products.ProductId),0) as Popularity, products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 ORDER BY Quantity = 0, $order $ordertype";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->Stock = $row['Stock'];
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function Getprices($id)
    {
        $p = new Price();
        return $p->GetpricesForOneProduct($id);
    }

    public function GetStats($id)
    {
        $s = new Stat();
        return $s->GetStatsForOneProduct($id);
    }

    public function GetProductColors($id)
    {
        $p = new ProductColor();
        return $p->GetProductColorsForOneProduct($id);
    }

    public function GetGuarantees($id)
    {
        $g = new Guarantee();
        return $g->GetGuaranteesForOneProduct($id);
    }

    public function GetProtocols($id)
    {
        $p = new Protocol();
        return $p->GetProtocolsForOneProduct($id);
    }

    public function GetMenus($id)
    {
        $m = new Menu();
        return $m->GetMenusForOneProduct($id);
    }

    public function GetMenus2(Product $product)
    {
        $m = new Menu();
        return $m->GetMenusForOneProduct2($product->getProductId());
    }

    public function GetDiscount($id)
    {
        $d = new Discount();
        return $d->GetDiscountsForOneProduct($id);
    }

    public function GetProperties($id)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProductAndPropertyDataSource.inc';

        $p = new ProductAndPropertyDataSource();
        $p->open();
        $paps = $p->GetPropertiesForOneProduct($id);
        $p->close();
        return $paps;
    }

    public function SearchProducts($s)
    {
        $SQL = "Select products.ProductId , products.Stock , products.Downloadable , products.DownloadContent ,products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%') AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->Stock = $row['Stock'];
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function CSearchProducts($s)
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Downloadable , products.DownloadContent ,products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%') AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC  ";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }


    public function FindSpecialOffers()
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Downloadable , products.DownloadContent , products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) = 1 AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC  ";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function FindSpecialOffers2($specialoffertitle)
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Downloadable , products.DownloadContent , products.Name ,(SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId ORDER BY SpecialOfferId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId AND specialoffers.SpecialOfferTitle = " . $specialoffertitle .  " ORDER BY SpecialOfferId DESC LIMIT 1 ) AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC  ";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function AdvancedSearchProducts($group, $subgroup, $suppergroup, $order, $ordertype, $searchkey)
    {
        $SQL = "Select products.ProductId , products.Stock, products.Downloadable , products.DownloadContent , products.Name,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO , (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName  , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity ,(Select Sum(Visit) from stats where Product = products.ProductId) as Visits ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (products.LatinName LIKE  '%$searchkey%' || products.Name LIKE  '%$searchkey%' || logos.Name LIKE  '%$searchkey%' || logos.LatinName LIKE  '%$searchkey%' ||  products.ProductId = '$searchkey' ||  products.Keywords LIKE '%$searchkey%') $group $subgroup $suppergroup ORDER BY $order $ordertype";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $product->Visits = $row['Visits'];
            $products[] = $product;
        }
        return $products;
    }

    public function SearchBrands($brand)
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Downloadable , products.DownloadContent,products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 AND products.Brand = " . $brand . " ORDER BY Quantity =0, ProductId DESC ";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setStock($row['Stock']);
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

    public function MaxId()
    {
        $Id = "SELECT MAX(ProductId) from products";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(ProductId)'];
        }
    }

    public function TotalPosts()
    {
        $SQL = "SELECT * from products";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        return $i;
    }

    public function mres($value)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        return str_replace($search, $replace, $value);
    }


    public function FillRandomProduct()
    {
        $SQL = "Select products.ProductId , products.Name  , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , logos.LatinName as BLName,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells ,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where products.Activated = 1 ORDER BY RAND() LIMIT 16";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setImage($row['Image']);
            $products[] = $product;
        }
        return $products;
    }

    public function FillByCount($count)
    {
        $SQL = "Select products.ProductId , products.Name  , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , logos.LatinName as BLName,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells ,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where products.Activated = 1 ORDER BY ProductId DESC LIMIT " . $count;
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setImage($row['Image']);
            $products[] = $product;
        }
        return $products;
    }

    public function FillSpecialOfferProduct($specialoffertitle)
    {
        $SQL = "Select products.ProductId ,products.Stock , products.Name  , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , logos.LatinName as BLName,(SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId ORDER BY SpecialOfferId DESC LIMIT 1 ) as SO,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells ,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand  WHERE (SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId AND specialoffers.SpecialOfferTitle = " . $specialoffertitle .  " ORDER BY SpecialOfferId DESC LIMIT 1 ) AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC LIMIT 16 ";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->setImage($row['Image']);
            $products[] = $product;
        }
        return $products;
    }


    public function CFillLimit($order, $ordertype)
    {
        $SQL = "Select products.ProductId,products.Stock , products.Downloadable , products.DownloadContent ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Name ,IFNULL((Select Rate from opinions where ProductId = products.ProductId),0) as Popularity, products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 ORDER BY Quantity = 0, $order $ordertype Limit 16";
        $results = $this->da->execSelect($SQL);
        $products = array();
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->setProductId($row['ProductId']);
            $product->setName($row['Name']);
            $product->Stock = $row['Stock'];
            $product->setDownloadable($row['Downloadable']);
            $product->setDownloadContent($row['DownloadContent']);

            $product->setLatinName($row['LatinName']);
            $product->setDescription($row['Description']);
            $product->setImage($row['Image']);
            $product->setActivated($row['Activated']);
            $product->getBrand()->setLogoId($row['LogoId']);
            $product->getBrand()->setName($row['BName']);
            $product->getBrand()->setLatinName($row['BLName']);
            $product->setReview($row['Review']);
            $product->setKeywords($row['Keywords']);
            $product->setMetaDescription($row['MetaDescription']);
            $product->getUser()->setUserId($row['Coupon']);
            $product->getUser()->setName($row['Discount']);


            $product->SpecialOffer = $row['SO'];


            $product->getUser()->setFamily($row['Price']);
            $product->getUser()->setUsername($row['Quantity']);

            $product->getGroup()->setGroupId($row['GroupId']);
            $product->getGroup()->setName($row['gpName']);
            $product->getGroup()->setLatinName($row['gpLatinName']);


            $product->getSubGroup()->setSubGroupId($row['SubGroupId']);
            $product->getSubGroup()->setName($row['sgpName']);
            $product->getSubGroup()->setLatinName($row['sgpLatinName']);
            $product->getSubGroup()->setGroup($row['sgpGroup']);
            $product->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $product->getSupperGroup()->setName($row['ssgpName']);
            $product->getSupperGroup()->setLatinName($row['ssgpLatinName']);
            $product->getSupperGroup()->setGroup($row['ssgpGroup']);
            $product->getSupperGroup()->setSubGroup($row['ssgpGroup']);
            $products[] = $product;
        }
        return $products;
    }

}
