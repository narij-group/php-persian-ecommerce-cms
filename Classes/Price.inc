<?php

require_once 'DataAccess.inc';
require_once 'User.inc';

class Price {

    public $PriceId;
    public $Product;
    public $Value;
    public $User;
    public $Date;

    public function __construct() {
        $this->PriceId = 0;
        $this->Product = 0;
        $this->Value = 0;
        $this->User = new User();
        $this->Date = "";
    }

    public function Insert() {
        $SQL = "Insert Into prices(`Product`,Value,User,Date) Values (" . $this->Product . "," . $this->Value . " , " . $this->User . ",'" . $this->Date . "')";              
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update prices Set Value=" . $this->Value . " Where PriceId=" . $this->PriceId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From prices Where PriceId= " . $this->PriceId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOnePrice() {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Where PriceId=" . $this->PriceId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
            $price->Date = $row['Date'];
            $price->User->UserId = $row['UserId'];
            $price->User->Name = $row['Name'];
            $price->User->Family = $row['Family'];
            $price->User->Username = $row['Username'];
            return $price;
        }
    }

    public function Fill() {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $prices = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
            $price->Date = $row['Date'];
            $price->User->UserId = $row['UserId'];
            $price->User->Name = $row['Name'];
            $price->User->Family = $row['Family'];
            $price->User->Username = $row['Username'];
            $prices[$i] = $price;
            $i++;
        }
        return $prices;
    }
    public function LimitedFill($limit) {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Limit $limit ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $prices = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
            $price->Date = $row['Date'];
            $price->User->UserId = $row['UserId'];
            $price->User->Name = $row['Name'];
            $price->User->Family = $row['Family'];
            $price->User->Username = $row['Username'];
            $prices[$i] = $price;
            $i++;
        }
        return $prices;
    }
    public function GetThisUserPrices($user) {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Where prices.User = $user ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $prices = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
            $price->Date = $row['Date'];
            $price->User->UserId = $row['UserId'];
            $price->User->Name = $row['Name'];
            $price->User->Family = $row['Family'];
            $price->User->Username = $row['Username'];
            $prices[$i] = $price;
            $i++;
        }
        return $prices;
    }
    
    public function CustomeFill($group,$subgroup,$suppergroup,$brand) {
        $SQL = "Select prices.PriceId , prices.Value From `prices` Inner Join products ON products.ProductId = prices.Product Where products.Group = $group AND products.SubGroup = $subgroup AND products.SupperGroup = $suppergroup AND products.Brand = $brand";
        echo $SQL;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $prices = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Value = $row['Value'];        
            $prices[$i] = $price;
            $i++;
        }
        return $prices;
    }        

    public function GetPricesForOneProduct($productId) {
        $SQL = "Select * From prices Inner Join users On prices.User = users.UserId Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $prices = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Date = $row['Date'];
            $price->Value = $row['Value'];
            $price->User->UserId = $row['UserId'];
            $price->User->Name = $row['Name'];
            $price->User->Family = $row['Family'];
            $price->User->Username = $row['Username'];
            $prices[$i] = $price;
            $i++;
        }
        return $prices;
    }

    public function GetLastPriceForOneProduct($productId) {
        $SQL = "Select * From prices Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
        }
        if (isset($price->Value)) {
            return $price->Value;
        }else {
            return 0;
        }
    }

    public function GetMinPrice($productId) {
        $SQL = "Select MIN(Value) AS LowestPrice From prices Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();            
            $price->Value = $row['LowestPrice'];
        }        
        return $price->Value;        
    }
    public function GetLowesPrice() {
        $SQL = "Select MIN(Value) AS LowestPrice From prices";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();            
            $price->Value = $row['LowestPrice'];
        }        
        return $price->Value;        
    }
    public function GetLowestPriceProductId() {        
        $SQL = "Select * from prices ORDER BY Value ASC Limit 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();                        
            $price->Product = $row['Product'];
        }        
        return $price->Product;        
    }
    public function GetHighestPrice() {
        $SQL = "Select MAX(Value) AS HighestPrice From prices";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();            
            $price->Value = $row['HighestPrice'];
        }        
        return $price->Value;        
    }

}
