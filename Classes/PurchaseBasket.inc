<?php

require_once 'DataAccess.inc';
require_once 'Customer.inc';
require_once 'Product.inc';

class PurchaseBasket {

    public $PurchaseBasketId;
    public $Customer;
    public $Product;
    public $Price;
    public $Count;
    public $Date;
    public $Color;
    public $Guarantee;

    public function __construct() {
        $this->PurchaseBasketId = 0;
        $this->Customer = new Customer();
        $this->Product = new Product();
        $this->Price = 0;
        $this->Count = 0;
        $this->Color = 0;
        $this->Guarantee = 0;
        $this->Date = date("Y/m/d");
    }

    public function Insert() {

        $SQL = "Insert Into purchasebaskets(`Customer`,Product,Price,Count,Date,Color,Guarantee) Values (" . $this->Customer . "," . $this->Product . "," . $this->Price . "," . $this->Count . ",'" . $this->Date . "'," . $this->Color . "," . $this->Guarantee . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

//    public function Update() {
//        $SQL = "Update purchasebaskets Set `Customer`=" . $this->Customer . ",Product=" . $this->Product . " , Price = ".$this->Price." , Count = ".$this->Count.", Date='".$this->Date."' Where PurchaseBasketId=" . $this->PurchaseBasketId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
//    }

    public function UpdateQuantity() {
        $SQL = "Update purchasebaskets Set `Count`=" . $this->Count . " Where PurchaseBasketId=" . $this->PurchaseBasketId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From purchasebaskets Where PurchaseBasketId= " . $this->PurchaseBasketId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function isIteamExist($id, $c,$co) {
        $SQL = "Select * From purchasebaskets Where Product=" . $id . " AND Customer = '" . $c . "' AND Color=$co";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $purchasebasket = new PurchaseBasket();
            $purchasebasket->PurchaseBasketId = $row['PurchaseBasketId'];
            if ($results != NULL) {
                return TRUE;
            } else {
                return $purchasebasket->PurchaseBasketId;
            }
        }
    }

    public function FindOnePurchaseBasket() {
        $SQL = "Select purchasebaskets.PurchaseBasketId,purchasebaskets.Color,purchasebaskets.Guarantee, purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId WHERE  purchasebaskets.PurchaseBasketId = $this->PurchaseBasketId";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $purchasebasket = new PurchaseBasket();
            $purchasebasket->PurchaseBasketId = $row['PurchaseBasketId'];
            $purchasebasket->Price = $row['Price'];
            $purchasebasket->Count = $row['Count'];
            $purchasebasket->Date = $row['Date'];
            $purchasebasket->Color = $row['Color'];
            $purchasebasket->Guarantee = $row['Guarantee'];
            $purchasebasket->Product->ProductId = $row['ProductId'];
            $purchasebasket->Product->Name = $row['ProductName'];
            $purchasebasket->Product->LatinName = $row['LatinName'];
            $purchasebasket->Product->Description = $row['Description'];
            $purchasebasket->Product->Image = $row['Image'];
            $purchasebasket->Customer->CustomerId = $row['CustomerId'];
            $purchasebasket->Customer->Name = $row['CustomerName'];
            $purchasebasket->Customer->Family = $row['Family'];
            $purchasebasket->Customer->Email = $row['Email'];
            $purchasebasket->Customer->Password = $row['Password'];
            $purchasebasket->Customer->City = $row['City'];
            $purchasebasket->Customer->NationalityCode = $row['NationalityCode'];
            $purchasebasket->Customer->Address = $row['Address'];
            $purchasebasket->Customer->Estate = $row['Estate'];
            return $purchasebasket;
        }
    }

    public function Fill() {
        $SQL = "Select purchasebaskets.PurchaseBasketId,purchasebaskets.Color,purchasebaskets.Guarantee, purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $purchasebaskets = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $purchasebasket = new PurchaseBasket();
            $purchasebasket->PurchaseBasketId = $row['PurchaseBasketId'];
            $purchasebasket->Price = $row['Price'];
            $purchasebasket->Count = $row['Count'];
            $purchasebasket->Date = $row['Date'];
            $purchasebasket->Color = $row['Color'];
            $purchasebasket->Guarantee = $row['Guarantee'];
            $purchasebasket->Product->ProductId = $row['ProductId'];
            $purchasebasket->Product->Name = $row['ProductName'];
            $purchasebasket->Product->LatinName = $row['LatinName'];
            $purchasebasket->Product->Description = $row['Description'];
            $purchasebasket->Product->Image = $row['Image'];
            $purchasebasket->Customer->CustomerId = $row['CustomerId'];
            $purchasebasket->Customer->Name = $row['CustomerName'];
            $purchasebasket->Customer->Family = $row['Family'];
            $purchasebasket->Customer->Email = $row['Email'];
            $purchasebasket->Customer->Password = $row['Password'];
            $purchasebasket->Customer->City = $row['City'];
            $purchasebasket->Customer->NationalityCode = $row['NationalityCode'];
            $purchasebasket->Customer->Address = $row['Address'];
            $purchasebasket->Customer->Estate = $row['Estate'];
            $purchasebaskets[$i] = $purchasebasket;
            $i++;
        }
        return $purchasebaskets;
    }

    public function FindSomeonePurchaseBasket() {
        $SQL = "Select purchasebaskets.PurchaseBasketId, purchasebaskets.Color, purchasebaskets.Guarantee,purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName, products.Activated  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId Where Customer=" . $this->Customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $purchasebasket = new PurchaseBasket();
            $purchasebasket->PurchaseBasketId = $row['PurchaseBasketId'];
            $purchasebasket->Price = $row['Price'];
            $purchasebasket->Count = $row['Count'];
            $purchasebasket->Color = $row['Color'];
            $purchasebasket->Guarantee = $row['Guarantee'];
            $purchasebasket->Date = $row['Date'];
            $purchasebasket->Product->ProductId = $row['ProductId'];
            $purchasebasket->Product->Name = $row['ProductName'];
            $purchasebasket->Product->LatinName = $row['LatinName'];
            $purchasebasket->Product->Description = $row['Description'];
            $purchasebasket->Product->Image = $row['Image'];
            $purchasebasket->Product->Activated = $row['Activated'];
            $purchasebasket->Customer->CustomerId = $row['CustomerId'];
            $purchasebasket->Customer->Name = $row['CustomerName'];
            $purchasebasket->Customer->Family = $row['Family'];
            $purchasebasket->Customer->Email = $row['Email'];
            $purchasebasket->Customer->Password = $row['Password'];
            $purchasebasket->Customer->City = $row['City'];
            $purchasebasket->Customer->NationalityCode = $row['NationalityCode'];
            $purchasebasket->Customer->Address = $row['Address'];
            $purchasebasket->Customer->Estate = $row['Estate'];
            $purchasebaskets[$i] = $purchasebasket;
            $i++;
        }
        if ($i == 0) {
            return NULL;
        } else {
            return $purchasebaskets;
        }
    }

    public function purchasebasketCounter() {
        $SQL = "Select * From purchasebaskets Where purchasebaskets.Customer=" . $this->Customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i += $row['Count'];
        }
        return $i;
    }

    public function GetProducts($product) {
        $SQL = "Select purchasebaskets.PurchaseBasketId From purchasebaskets Where purchasebaskets.Product=" . $product;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pb = new PurchaseBasket();
            $pb->PurchaseBasketId = $row['PurchaseBasketId'];
            $pbs[$i] = $pb;
            $i++;
        }
        return $pbs;
    }

}
