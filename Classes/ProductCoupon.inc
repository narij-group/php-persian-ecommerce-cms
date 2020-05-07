<?php

require_once 'DataAccess.inc';
require_once 'User.inc';
require_once 'Product.inc';

class ProductCoupon {

    public $ProductCouponId;
    public $Date;
    public $Value;
    public $Product;
    public $User;    

    public function __construct() {
        $this->ProductCouponId = 0;
        $this->Date = date("Y/m/d");
        $this->Value = 0;        
        $this->Product = new Product();
        $this->User = new User();        
    }

    public function Insert() {

        $SQL = "Insert Into productcoupons(`Date`,Value,Product,User) Values ('" . $this->Date . "'," . $this->Value . "," . $this->Product . " , " . $this->User . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update productcoupons Set `Date`='" . $this->Date . "',Value = " . $this->Value . " Where ProductCouponId=" . $this->ProductCouponId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From productcoupons Where ProductCouponId= " . $this->ProductCouponId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneProductCoupon() {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId  Where ProductCouponId=" . $this->ProductCouponId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            return $productcoupon;
        }
    }

    public function FindOneProductCoupons($product) {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId Where productcoupons.Product=" . $product;        
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            return $productcoupon;
        }
    }
    
    public function FindOneProductCoupons2($product) {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Value from productcoupons Where Product=" . $product ." Order by ProductCouponId DESC LIMIT 1";                
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {                                    
            return $row['Value'];
        }
    }
    public function GetLastProductCouponsForOneProductInfo($product) {
        $SQL = "Select productcoupons.ProductCouponId,productcoupons.Value from productcoupons Where Product=" . $product ." Order by ProductCouponId DESC LIMIT 1";                
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {                                    
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Value = $row['Value'];
            return $productcoupon;
        }        
    }

    public function Fill() {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $productcoupons = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            $productcoupons[$i] = $productcoupon;
            $i++;
        }
        return $productcoupons;
    }

}
