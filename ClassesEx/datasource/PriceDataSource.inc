<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Price.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class PriceDataSource
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

    public function Insert(Price $price)
    {
        $SQL = "Insert Into prices(`Product`,Value,User,Date) Values (" . $price->Product . "," . $price->Value . " , " . $price->User . ",'" . $price->Date . "')";
        $this->da->exec($SQL);
    }

    public function Update(Price $price)
    {
        $SQL = "Update prices Set Value=" . $price->Value . " Where PriceId=" . $price->PriceId . "";
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From prices Where PriceId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOnePriceBasedOnId($id)
    {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Where PriceId=" . $id;
        $results = $this->da->execSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId ";
        $results = $this->da->execSelect($SQL);
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

    public function LimitedFill($limit)
    {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Limit $limit ";
        $results = $this->da->execSelect($SQL);
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

    public function GetThisUserPrices($user)
    {
        $SQL = "Select prices.PriceId , prices.Value , prices.Product , prices.Date , users.UserId , users.Name , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `prices` Inner Join users On prices.User = users.UserId Where prices.User = $user ";
        $results = $this->da->execSelect($SQL);
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

    public function CustomeFill($group, $subgroup, $suppergroup, $brand)
    {
        $SQL = "Select prices.PriceId , prices.Value From `prices` Inner Join products ON products.ProductId = prices.Product Where products.Group = $group AND products.SubGroup = $subgroup AND products.SupperGroup = $suppergroup AND products.Brand = $brand";
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
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


    public function DeletePricesRelatedToProduct($productId)
    {
        $SQL = "DELETE From prices Where prices.Product=" . $productId;
        $this->da->exec($SQL);
    }


    public function GetPricesForOneProduct($productId)
    {
        $SQL = "Select * From prices Inner Join users On prices.User = users.UserId Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
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

    public function GetLastPriceForOneProduct($productId)
    {
        $SQL = "Select * From prices Where Product=" . $productId;
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->PriceId = $row['PriceId'];
            $price->Product = $row['Product'];
            $price->Value = $row['Value'];
        }
        if (isset($price->Value)) {
            return $price->Value;
        } else {
            return 0;
        }
    }

    public function GetMinPrice($productId)
    {
        $SQL = "Select MIN(Value) AS LowestPrice From prices Where Product=" . $productId;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->Value = $row['LowestPrice'];
        }
        return $price->Value;
    }

    public function GetLowesPrice()
    {
        $SQL = "Select MIN(Value) AS LowestPrice From prices";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->Value = $row['LowestPrice'];
        }
        return $price->Value;
    }

    public function GetLowestPriceProductId()
    {
        $SQL = "Select * from prices ORDER BY Value ASC Limit 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->Product = $row['Product'];
        }
        return $price->Product;
    }

    public function GetHighestPrice()
    {
        $SQL = "Select MAX(Value) AS HighestPrice From prices";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $price = new Price();
            $price->Value = $row['HighestPrice'];
        }
        return $price->Value;
    }

}
