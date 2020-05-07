<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/PurchaseBasket.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class PurchaseBasketDataSource_OLD
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

    public function Insert(PurchaseBasket $purchaseBasket)
    {
        $SQL = "Insert Into purchasebaskets(`Customer`,Product,Price,Count,Date,Color,Guarantee, Session) Values (" . $purchaseBasket->Customer . "," . $purchaseBasket->Product . "," . $purchaseBasket->Price . "," . $purchaseBasket->Count . ",'" . $purchaseBasket->Date . "'," . $purchaseBasket->Color . "," . $purchaseBasket->Guarantee .  ")";

//        echo "IN SQL : " . $SQL;
        $this->da->exec($SQL);
    }

//    public function Update() {
//        $SQL = "Update purchasebaskets Set `Customer`=" . $this->Customer . ",Product=" . $this->Product . " , Price = ".$this->Price." , Count = ".$this->Count.", Date='".$this->Date."' Where PurchaseBasketId=" . $this->PurchaseBasketId . "";
//        $db = new DataAccess();
//        $db->execute($SQL);
//    }

    public function UpdateQuantity(PurchaseBasket $purchaseBasket)
    {
        $SQL = "Update purchasebaskets Set `Count`=" . $purchaseBasket->Count . " Where PurchaseBasketId=" . $purchaseBasket->PurchaseBasketId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From purchasebaskets Where PurchaseBasketId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeletePurchaseBasketsRelatedToCustomer($customer)
    {
        $SQL = "DELETE From purchasebaskets  Where Customer=" . $customer;
        $this->da->exec($SQL);
    }


    public function DeletePurchaseBasketsRelatedToProducts($product)
    {
        $SQL = "DELETE From purchasebaskets Where purchasebaskets.Product=" . $product;
        $this->da->exec($SQL);
    }


    public function isIteamExist($id, $c, $co)
    {
        $SQL = "Select * From purchasebaskets Where Product=" . $id . " AND Customer = '" . $c . "' AND Color=$co";
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
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

    public function isIteamExistWithoutColorCheck($id, $c)
    {
        $SQL = "Select * From purchasebaskets Where Product=" . $id . " AND Customer = '" . $c . "'";
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
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

    public function FindOnePurchaseBasket($id)
    {
        $SQL = "Select purchasebaskets.PurchaseBasketId,purchasebaskets.Color,purchasebaskets.Guarantee, purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId WHERE  purchasebaskets.PurchaseBasketId = {$id}";
        $results = $this->da->execSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select purchasebaskets.PurchaseBasketId,purchasebaskets.Color,purchasebaskets.Guarantee, purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId ";
        $results = $this->da->execSelect($SQL);
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

    public function FindSomeonePurchaseBasket($customer)
    {
        $SQL = "Select purchasebaskets.PurchaseBasketId, purchasebaskets.Color, purchasebaskets.Guarantee,purchasebaskets.Price , purchasebaskets.Count , purchasebaskets.Date , products.ProductId , products.Name as ProductName , products.LatinName, products.Activated  , products.Description , products.Image , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From purchasebaskets  Inner Join customers On purchasebaskets.Customer = customers.CustomerId  Inner Join products On purchasebaskets.Product = products.ProductId Where Customer=" . $customer;
        $results = $this->da->execSelect($SQL);
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

    public function purchasebasketCounter($customer)
    {
        $SQL = "Select * From purchasebaskets Where purchasebaskets.Customer=" . $customer;
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i += $row['Count'];
        }
        return $i;
    }

    public function GetProducts($product)
    {
        $SQL = "Select purchasebaskets.PurchaseBasketId From purchasebaskets Where purchasebaskets.Product=" . $product;
        $results = $this->da->execSelect($SQL);
        $i = 0;
        $pbs = array();
        while ($row = mysqli_fetch_array($results)) {
            $pb = new PurchaseBasket();
            $pb->PurchaseBasketId = $row['PurchaseBasketId'];
            $pbs[$i] = $pb;
            $i++;
        }
        return $pbs;
    }

}
