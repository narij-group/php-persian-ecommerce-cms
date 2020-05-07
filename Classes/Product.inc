<?php

require_once 'DataAccess.inc';
require_once 'User.inc';
require_once 'Category.inc';
require_once 'Price.inc';
require_once 'Stat.inc';
require_once 'Protocol.inc';
require_once 'Menu.inc';
require_once 'Guarantee.inc';
require_once 'ProductColor.inc';
require_once 'Discount.inc';
require_once 'Group.inc';
require_once 'SubGroup.inc';
require_once 'SupperGroup.inc';
require_once 'ProductAndProperty.inc';
require_once 'Logo.inc';

class Product implements JsonSerializable
{

    public $ProductId;
    public $Name;
    public $LatinName;
    public $Description;
    public $User;
    public $Image;
    public $Keywords;
    public $MetaDescription;
    public $Review;
    public $Brand;
    public $Group;
    public $SubGroup;
    public $SupperGroup;
    public $Activated;

    public function __construct()
    {
        $this->ProductId = 0;
        $this->Group = new Group();
        $this->SubGroup = new SubGroup();
        $this->SupperGroup = new SupperGroup();
        $this->Name = "";
        $this->LatinName = "";
        $this->Description = "";
        $this->User = new User();
        $this->Image = "";
        $this->Keywords = "";
        $this->MetaDescription = "";
        $this->Review = "";
        $this->Brand = new Logo();
        $this->Activated = 0;
    }

    public function InsertBlank()
    {
        $SQL = "Insert Into products(Name,Activated) Values ('Empty',0)";
        $db = new DataAccess();
        return $db->execute($SQL);
    }

    public function FindEmptyProducts()
    {
        $SQL = "Select products.ProductId from products where name = 'Empty'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $products[$i] = $row['ProductId'];
            $i++;
        }
        return $products;
    }

    public function Activate($id)
    {
        $SQL = "Update products Set Activated = 1 Where ProductId=" . $id . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Deactivate($id)
    {
        $SQL = "Update products Set Activated = 0 Where ProductId=" . $id . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function MoveTo($id, $group, $subgroup, $suppergroup)
    {
        $SQL = "Update products Set `Group` = " . $group . " , SubGroup = " . $subgroup . " , SupperGroup = " . $suppergroup . " Where ProductId=" . $id . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FillTheBlank()
    {
        $SQL = "Update products Set `Name`='" . $this->Name . "',`LatinName`='" . $this->LatinName . "',Description='" . $this->Description . "' , User = " . $this->User . " , Review = '" . $this->Review . "' , Brand =" . $this->Brand . " , Image = '" . $this->Image . "' , Activated=" . $this->Activated . " , Keywords = '" . $this->Keywords . "' , MetaDescription = '" . $this->MetaDescription . "',`Group` = " . $this->Group . ",SubGroup = " . $this->SubGroup . " , SupperGroup = " . $this->SupperGroup . " Where ProductId=" . $this->ProductId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function AppInsert()
    {
        $SQL = "Update products Set `Name`='" . $this->Name . "',`LatinName`='" . $this->LatinName . "',User = " . $this->User . " , Brand =" . $this->Brand . " , Activated = 0 ,`Group` = " . $this->Group . ", Image = '" . $this->Image . "',SubGroup = " . $this->SubGroup . " , SupperGroup = " . $this->SupperGroup . " Where ProductId=" . $this->ProductId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From products Where ProductId= " . $this->ProductId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneProduct()
    {
        $SQL = "Select products.ProductId , products.Name ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells  ,(Select Sum(Visit) from stats where Product = products.ProductId) as Visits, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId Where ProductId=" . $this->ProductId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Name2'];
            $product->User->Family = $row['Price'];
            $product->Family = $row['Family'];
            $product->User->Username = $row['Quantity'];
            $product->User->Password = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $product->Visits = $row['Visits'];
            $product->Sells = $row['Sells'];
            return $product;
        }
    }

    public function FindOneProduct2()
    {
        $SQL = "Select User from products where ProductId = $this->ProductId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function FindOneProductImage()
    {
        $SQL = "Select Image From products Where ProductId=" . $this->ProductId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            echo $row['Image'];
        }
    }

    public function Fill()
    {
        $SQL = "Select products.ProductId , products.Name , (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId ORDER BY ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function CAdvancedFill($query, $order, $ordertype)
    {
        $SQL = "Select products.ProductId,IFNULL((Select Sum(Visit) from stats where Product = products.ProductId),0) as Visits , products.Name ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Name ,IFNULL((Select Rate from opinions where ProductId = products.ProductId),0) as Popularity , (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity, products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 $query ORDER BY Quantity = 0 , $order $ordertype";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Image = $row['Image'];
            $product->Sells = $row['Sells'];
            $product->SpecialOffer = $row['SO'];
            $product->Price = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->User->Password = $row['Discount'];
            $product->Group->GroupId = $row['GroupId'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function FillBySG($subgroupid)
    {
        $SQL = "Select ProductId,Activated,SubGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND SubGroup = $subgroupid ORDER BY Quantity =0, ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $products[$i] = $row['ProductId'];
            $i++;
        }
        return $products;
    }

    public function FillBySG2($subgroupid)
    {
        $SQL = "Select ProductId,Activated,SubGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND SubGroup = $subgroupid ORDER BY ProductId DESC Limit 16";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $products[$i] = $row['ProductId'];
            $i++;
        }
        return $products;
    }

    public function FillByGroup($groupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `Group` = $groupid ORDER BY ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function GetThisUserProducts($user)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `User` = $user ORDER BY ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function FillBySGroup($sgroupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `SubGroup` = $sgroupid ORDER BY ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function FillBySSGroup($ssgroupid)
    {
        $SQL = "Select products.ProductId,products.Image as img FROM products WHERE `SupperGroup` = $ssgroupid ORDER BY ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Image = $row['img'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function FillBySPG($suppergroupid)
    {
        $SQL = "Select ProductId,Activated,SupperGroup,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity FROM products WHERE Activated = 1 AND SupperGroup = $suppergroupid ORDER BY Quantity =0, ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $products[$i] = $row['ProductId'];
            $i++;
        }
        return $products;
    }

    public function FillDependOnSells2()
    {
        $SQL = "Select products.ProductId , products.Name  , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , logos.LatinName as BLName,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells ,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND products.Activated = 1  AND (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 ORDER BY Sells DESC Limit 16";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->Image = $row['Image'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function FillIfExists()
    {
        $SQL = "Select products.ProductId , products.Name ,logos.LogoId,logos.Name as BName , logos.LatinName as BLName , IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity ,  products.Review , products.LatinName , products.Description , products.Image, products.Keywords, products.MetaDescription , users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId  Inner Join logos ON logos.LogoId = products.Brand Where (Select Sum(Quantity) from productcolors where Product = products.ProductId) != 0 AND products.Activated = 1 ORDER BY ProductId DESC Limit 16";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
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
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function CFill($order, $ordertype)
    {
        $SQL = "Select products.ProductId ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Name ,IFNULL((Select Rate from opinions where ProductId = products.ProductId),0) as Popularity, products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 ORDER BY Quantity = 0, $order $ordertype";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
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

    public function Getprices()
    {
        $p = new Price();
        return $p->GetpricesForOneProduct($this->ProductId);
    }

    public function GetStats()
    {
        $s = new Stat();
        return $s->GetStatsForOneProduct($this->ProductId);
    }

    public function GetProductColors()
    {
        $p = new ProductColor();
        return $p->GetProductColorsForOneProduct($this->ProductId);
    }

    public function GetGuarantees()
    {
        $g = new Guarantee();
        return $g->GetGuaranteesForOneProduct($this->ProductId);
    }

    public function GetProtocols()
    {
        $p = new Protocol();
        return $p->GetProtocolsForOneProduct($this->ProductId);
    }

    public function GetMenus()
    {
        $m = new Menu();
        return $m->GetMenusForOneProduct($this->ProductId);
    }

    public function GetMenus2()
    {
        $m = new Menu();
        return $m->GetMenusForOneProduct2($this->ProductId);
    }

    public function GetDiscount()
    {
        $d = new Discount();
        return $d->GetDiscountsForOneProduct($this->ProductId);
    }

    public function GetProperties()
    {
        $p = new ProductAndProperty();
        return $p->GetPropertiesForOneProduct($this->ProductId);
    }

    public function SearchProducts()
    {
        $s = $this->Name;
        $SQL = "Select products.ProductId , products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%' ORDER BY Quantity =0, ProductId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function CSearchProducts()
    {
        $s = $this->Name;
        $SQL = "Select products.ProductId , products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%' AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC  ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }


    public function FindSpecialOffers()
    {
        $SQL = "Select products.ProductId , products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) = 1 AND products.Activated = 1 ORDER BY Quantity =0, ProductId DESC  ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function AdvancedSearchProducts($group, $subgroup, $suppergroup, $order, $ordertype, $searchkey)
    {
        $SQL = "Select products.ProductId , products.Name,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO , (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName  , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity ,(Select Sum(Visit) from stats where Product = products.ProductId) as Visits ,IFNULL((Select Sum(`Count`) from factorproducts where Product = products.ProductId),0) as Sells , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE (products.LatinName LIKE  '%$searchkey%' || products.Name LIKE  '%$searchkey%' || logos.Name LIKE  '%$searchkey%' || logos.LatinName LIKE  '%$searchkey%' ||  products.ProductId = '$searchkey' ||  products.Keywords LIKE '%$searchkey%') $group $subgroup $suppergroup ORDER BY $order $ordertype";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $product->Visits = $row['Visits'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function SearchBrands()
    {
        $SQL = "Select products.ProductId , products.Name ,(SELECT discounts.SpecialOffer FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as SO, (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) as Price ,(SELECT discounts.Value FROM discounts WHERE discounts.Product = products.ProductId ORDER BY DiscountId DESC LIMIT 1 ) as Discount,(SELECT productcoupons.Value FROM productcoupons WHERE productcoupons.Product = products.ProductId ORDER BY ProductCouponId DESC LIMIT 1 ) as Coupon , products.Activated , products.Review , products.LatinName,logos.LogoId,logos.Name as BName , groups.GroupId , groups.Name as gpName , groups.LatinName as gpLatinName , subgroups.SubGroupId , subgroups.Name as sgpName , subgroups.Group as sgpGroup , subgroups.LatinName as sgpLatinName , suppergroups.SupperGroupId , suppergroups.SubGroup as ssgpSubGroup , suppergroups.Name as ssgpName , suppergroups.Group as ssgpGroup , suppergroups.LatinName as ssgpLatinName , logos.LatinName as BLName,IFNULL((Select Sum(Quantity) from productcolors where Product = products.ProductId),0) as Quantity , products.Description , products.Image, products.Keywords, products.MetaDescription, users.UserId , users.Name as Name2 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From products Inner Join users On products.User = users.UserId Inner Join logos ON logos.LogoId = products.Brand Inner Join groups on products.Group = groups.GroupId Inner Join subgroups ON products.SubGroup = subgroups.SubGroupId Inner Join suppergroups on products.SupperGroup = suppergroups.SupperGroupId WHERE products.Activated = 1 AND products.Brand = " . $this->Brand . " ORDER BY Quantity =0, ProductId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $products = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $product = new Product();
            $product->ProductId = $row['ProductId'];
            $product->Name = $row['Name'];
            $product->LatinName = $row['LatinName'];
            $product->Description = $row['Description'];
            $product->Image = $row['Image'];
            $product->Activated = $row['Activated'];
            $product->Brand->LogoId = $row['LogoId'];
            $product->Brand->Name = $row['BName'];
            $product->Brand->LatinName = $row['BLName'];
            $product->Review = $row['Review'];
            $product->Keywords = $row['Keywords'];
            $product->MetaDescription = $row['MetaDescription'];
            $product->User->UserId = $row['Coupon'];
            $product->User->Name = $row['Discount'];
            $product->SpecialOffer = $row['SO'];
            $product->User->Family = $row['Price'];
            $product->User->Username = $row['Quantity'];
            $product->Group->GroupId = $row['GroupId'];
            $product->Group->Name = $row['gpName'];
            $product->Group->LatinName = $row['gpLatinName'];
            $product->SubGroup->SubGroupId = $row['SubGroupId'];
            $product->SubGroup->Name = $row['sgpName'];
            $product->SubGroup->LatinName = $row['sgpLatinName'];
            $product->SubGroup->Group = $row['sgpGroup'];
            $product->SupperGroup->SupperGroupId = $row['SupperGroupId'];
            $product->SupperGroup->Name = $row['ssgpName'];
            $product->SupperGroup->LatinName = $row['ssgpLatinName'];
            $product->SupperGroup->Group = $row['ssgpGroup'];
            $product->SupperGroup->SubGroup = $row['ssgpGroup'];
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    public function MaxId()
    {
        $Id = "SELECT MAX(ProductId) from products";
        $db = new DataAccess();
        $results = $db->executeSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MAX(ProductId)'];
        }
    }

    public function TotalPosts()
    {
        $SQL = "SELECT * from products";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

}
