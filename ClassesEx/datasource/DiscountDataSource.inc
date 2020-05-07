<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Discount.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class DiscountDataSource
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


    public function Insert(Discount $discount)
    {
        $SQL = "Insert Into discounts(`Product`,Value,User) Values (" . $discount->getProduct() . "," . $discount->getValue() . "," . $discount->getUser() . ")";
        $this->da->exec($SQL);
    }

    public function Update(Discount $discount)
    {
        $SQL = "Update discounts Set Value=" . $discount->getValue() . " Where DiscountId=" . $discount->getDiscountId() . "";
        $this->da->exec($SQL);
    }

    public function SetSpecialOffer(Discount $discount)
    {
        $SQL = "Update discounts Set SpecialOffer=" . $discount->getSpecialOffer() . " Where DiscountId=" . $discount->getDiscountId() . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From discounts Where DiscountId= " . $id;
        $this->da->exec($SQL);
    }


    public function DeleteDiscountsRelatedToProduct($productId)
    {
        $SQL = "DELETE From discounts Where Product=" . $productId;
        $this->da->exec($SQL);
    }


    public function FindOneDiscountBasedOnId($id)
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where DiscountId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            return $discount;
        }
    }

    public function Fill()
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User ORDER BY discounts.DiscountId DESC";
        $results = $this->da->execSelect($SQL);
        $discounts = array();
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            $discounts[] = $discount;
        }
        return $discounts;
    }

    public function GetDiscountsForOneProduct($productId)
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
        $discounts = array();
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            $discounts[] = $discount;
        }
        return $discounts;
    }

    public function GetLastDiscountForTheProduct($productId)
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId . " Limit 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            return $discount;
        }
    }

    public function GetThisUserDiscounts($user)
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.User=" . $user;
        $results = $this->da->execSelect($SQL);
        $discounts = array();
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            $discounts[] = $discount;
        }
        return $discounts;
    }

    public function GetLastDiscountForOneProduct($productId)
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
        }
        if (isset($discount->Value)) {
            return $discount->Value;
        }
    }

    public function GetLastDiscountForOneProductInfo($productId)
    {
        $SQL = "Select discounts.DiscountId From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            return $discount;
        }
    }

    public function FindSpecialOffers()
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, (Select Sum(Quantity) from productcolors where Product = products.ProductId) as Quantity, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Activated , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.SpecialOffer = 1 AND (Select Sum(Quantity) from productcolors where productcolors.Product = discounts.Product) != 0 AND products.Activated = 1 ORDER BY discounts.DiscountId DESC";
        $results = $this->da->execSelect($SQL);
        $discounts = array();
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discount->getUser()->setUserId($row['UserId']);
            $discount->getUser()->setName($row['UName']);
            $discount->getUser()->setFamily($row['Family']);
            $discount->getUser()->setUsername($row['Username']);
            $discounts[] = $discount;
        }
        return $discounts;
    }

    public function FindSpecialOffers2()
    {
        $SQL = "Select discounts.DiscountId , discounts.Value, (Select Sum(Quantity) from productcolors where Product = products.ProductId) as Quantity, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Activated , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.SpecialOffer = 1 AND (Select Sum(Quantity) from productcolors where productcolors.Product = discounts.Product) != 0 AND products.Activated = 1 ORDER BY discounts.DiscountId DESC Limit 15";
        $results = $this->da->execSelect($SQL);
        $discounts = array();
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->setDiscountId($row['DiscountId']);
            $discount->setValue($row['Value']);
            $discount->setSpecialOffer($row['SpecialOffer']);
            $discount->getProduct()->setProductId($row['ProductId']);
            $discount->getProduct()->setName($row['ProductName']);
            $discount->getProduct()->setLatinName($row['LatinName']);
            $discount->getProduct()->setDescription($row['Description']);
            $discount->getProduct()->setImage($row['Image']);
            $discounts[] = $discount;
        }
        return $discounts;
    }

}
