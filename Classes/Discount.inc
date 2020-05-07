<?php

require_once 'DataAccess.inc';
require_once 'Product.inc';
require_once 'User.inc';

class Discount {

    public $DiscountId;
    public $Product;
    public $Value;
    public $User;
    public $SpecialOffer;

    public function __construct() {
        $this->DiscountId = 0;
        $this->Product = new Product();
        $this->Value = 0;
        $this->SpecialOffer = 0;
        $this->User = new User();
    }

    public function Insert() {
        $SQL = "Insert Into discounts(`Product`,Value,User) Values (" . $this->Product . "," . $this->Value . "," . $this->User . ")";        
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update discounts Set Value=" . $this->Value . " Where DiscountId=" . $this->DiscountId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    
    public function SetSpecialOffer() {
        $SQL = "Update discounts Set SpecialOffer=" . $this->SpecialOffer . " Where DiscountId=" . $this->DiscountId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From discounts Where DiscountId= " . $this->DiscountId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneDiscount() {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where DiscountId=" . $this->DiscountId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            return $discount;
        }
    }

    public function Fill() {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User ORDER BY discounts.DiscountId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $discounts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            $discounts[$i] = $discount;
            $i++;
        }
        return $discounts;
    }

    public function GetDiscountsForOneProduct($productId) {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $discounts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            $discounts[$i] = $discount;
            $i++;
        }
        return $discounts;
    }

    public function GetLastDiscountForTheProduct($productId) {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId ." Limit 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            return $discount;
        }
    }
    public function GetThisUserDiscounts($user) {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.User=" . $user;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $discounts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            $discounts[$i] = $discount;
            $i++;
        }
        return $discounts;
    }

    public function GetLastDiscountForOneProduct($productId) {
        $SQL = "Select discounts.DiscountId , discounts.Value, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
        }
        if (isset($discount->Value)) {
            return $discount->Value;
        }
    }
    public function GetLastDiscountForOneProductInfo($productId) {
        $SQL = "Select discounts.DiscountId From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];            
            return $discount;
        }          
    }
    
    public function FindSpecialOffers(){
        $SQL = "Select discounts.DiscountId , discounts.Value, (Select Sum(Quantity) from productcolors where Product = products.ProductId) as Quantity, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Activated , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.SpecialOffer = 1 AND (Select Sum(Quantity) from productcolors where productcolors.Product = discounts.Product) != 0 AND products.Activated = 1 ORDER BY discounts.DiscountId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $discounts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Description = $row['Description'];
            $discount->Product->Image = $row['Image'];
            $discount->User->UserId = $row['UserId'];
            $discount->User->Name = $row['UName'];
            $discount->User->Family = $row['Family'];
            $discount->User->Username = $row['Username'];
            $discounts[$i] = $discount;
            $i++;
        }
        return $discounts;
    }

    public function FindSpecialOffers2(){
        $SQL = "Select discounts.DiscountId , discounts.Value, (Select Sum(Quantity) from productcolors where Product = products.ProductId) as Quantity, discounts.SpecialOffer , products.ProductId , products.Name as ProductName , products.LatinName , products.Activated , products.Description , products.Image , users.UserId , users.Name as UName , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From discounts inner join products on products.ProductId = discounts.Product inner join users on users.UserId = discounts.User Where discounts.SpecialOffer = 1 AND (Select Sum(Quantity) from productcolors where productcolors.Product = discounts.Product) != 0 AND products.Activated = 1 ORDER BY discounts.DiscountId DESC Limit 15";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $discounts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $discount = new Discount();
            $discount->DiscountId = $row['DiscountId'];
            $discount->Value = $row['Value'];
            $discount->SpecialOffer = $row['SpecialOffer'];
            $discount->Product->ProductId = $row['ProductId'];
            $discount->Product->Name = $row['ProductName'];
            $discount->Product->LatinName = $row['LatinName'];
            $discount->Product->Image = $row['Image'];
            $discounts[$i] = $discount;
            $i++;
        }
        return $discounts;
    }

}
