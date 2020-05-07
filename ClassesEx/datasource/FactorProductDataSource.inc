<?php

date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/FactorProduct.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";


class FactorProductDataSource
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


    public function Insert(FactorProduct $factorProduct)
    {
        $SQL = "Insert Into factorproducts(`Factor`,Product,Services,Date,Price,Count,Color,Guarantee,Coupon,TraceCode,Time,Comment,PaymentMethod,ShippingMethod,Status,PaymentStatus,Amount,Authority) Values (" . $factorProduct->Factor . "," . $factorProduct->Product . ",'" . $factorProduct->Services . "','" . $factorProduct->Date . "'," . $factorProduct->Price . "," . $factorProduct->Count . ",'" . $factorProduct->Color . "','" . $factorProduct->Guarantee . "'," . $factorProduct->Coupon . "," . $factorProduct->TraceCode . ",'" . $factorProduct->Time . "','" . $factorProduct->Comment . "'," . $factorProduct->PaymentMethod . ",'" . $factorProduct->ShippingMethod . "'," . $factorProduct->Status . "," . $factorProduct->PaymentStatus . ",'" . $factorProduct->Amount . "','" . $factorProduct->Authority . "')";
        $this->da->exec($SQL);
    }

    public function Update(FactorProduct $factorProduct)
    {
        $SQL = "Update factorproducts Set `Factor`=" . $factorProduct->Factor . ",Price = " . $factorProduct->Price . ",Count = " . $factorProduct->Count . ",Color = '" . $factorProduct->Color . "',Services = '" . $factorProduct->Services . "',Product=" . $factorProduct->Product . " , Date = '" . $factorProduct->Date . "' , Guarantee = '" . $factorProduct->Guarantee . "', Comment = '" . $factorProduct->Comment . "', Coupon = " . $factorProduct->Coupon . ", TraceCode = " . $factorProduct->TraceCode . ", PaymentMethod = " . $factorProduct->PaymentMethod . ", ShippingMethod = '" . $factorProduct->ShippingMethod . "' Where FactorProductId=" . $factorProduct->FactorProductId . "";
        $this->da->exec($SQL);
    }

    public function UpdatePaymentStatus($id, $status)
    {
        $SQL = "Update factorproducts Set PaymentStatus = $status Where FactorProductId=" . $id . "";
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function UpdateAuthority(FactorProduct $factorProduct)
    {
        $SQL = "Update factorproducts Set Authority = " . $factorProduct->Authority . " Where FactorProductId=" . $factorProduct->FactorProductId . "";
        $this->da->exec($SQL);
    }

    public function UpdatePaymentMethod($id, $m)
    {
        $SQL = "Update factorproducts Set PaymentMethod = $m Where FactorProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function UpdateRefId(FactorProduct $factorProduct, $ref)
    {
        $SQL = "Update factorproducts Set RefId = '$ref' , PaymentStatus = 1 Where Amount=" . $factorProduct->Amount . " AND Authority = " . $factorProduct->Authority . "";
        $this->da->exec($SQL);
    }

    public function Preparing($id)
    {
        $SQL = "Update factorproducts Set Status = 1 Where FactorProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function Sent($id)
    {
        $SQL = "Update factorproducts Set Status = 2 Where FactorProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function CDelete($id)
    {
        $SQL = "Update factorproducts Set Status = 4 Where FactorProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function Canceled($id)
    {
        $SQL = "Update factorproducts Set Status = 3 Where FactorProductId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From factorproducts Where FactorProductId= " . $id;
        $this->da->exec($SQL);
    }


    public function DeleteFactorsRelatedToCustomer($id)
    {
        $SQL = "Select factorproducts.* From factorproducts Inner Join factors On factorproducts.Factor = factors.FactorId Where factors.Customer=" . $id;
        $this->da->exec($SQL);
    }


    public function isCodeAvailable($code)
    {
        $SQL = "Select * from factorproducts Where TraceCode = " . $code;
        $results = $this->da->execSelect($SQL);
        $check = true;
        if ($results != null) {
            while ($row = mysqli_fetch_array($results)) {
                $check = false;
            }
        }
        return $check;
    }

    public function FindOneFactorProductBasedOnId($id)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod ,factorproducts . Comment, factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId Inner Join products On factorproducts . Product = products . ProductId Where FactorProductId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Address = $row['Email'];
            $factorproduct->Factor->Customer->Mobile = $row['Mobile'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->Email = $row['Email'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Color = $row['Color'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            return $factorproduct;
        }
    }

    public function FindFactorProductsOnAuthority($authority)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . Authority , factorproducts . TraceCode, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod ,factorproducts . Comment, factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId Inner Join products On factorproducts . Product = products . ProductId Where Authority = '" . $authority . "'";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product = $row['ProductId'];
            $factorproduct->Factor = $row['FactorId'];
            $factorproduct->Customer = $row['Customer'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Color = $row['Color'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->Authority = $row['Authority'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function Fill()
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . RefId, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId WHERE PaymentStatus != 0 AND PaymentStatus != 3 AND Status != 4 ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->RefId = $row['RefId'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->City = $row['City'];
            $factorproduct->Factor->Customer->Address = $row['Address'];
            $factorproduct->Factor->Customer->Estate = $row['Estate'];
            $factorproduct->Factor->Customer->Phone = $row['Phone'];
            $factorproduct->Factor->Customer->Mobile = $row['Mobile'];
            $factorproduct->Factor->Customer->PostCode = $row['PostCode'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Color = $row['Color'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function getDates()
    {
        $SQL = "Select factorproducts . Date from factorproducts WHERE PaymentStatus != 0 AND PaymentStatus != 3 AND Status != 4 ORDER BY Date ASC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproducts[$i] = $row['Date'];
            $i++;
        }
        return $factorproducts;
    }

    public function FindAmountOfDate($date)
    {
        $SQL = "Select IFNULL(Sum(factorproducts . Amount), 0) as Amount from factorproducts WHERE  PaymentStatus = 1 AND Status != 3 AND Status != 4 AND factorproducts . Date = '$date'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Amount'];
        }
    }

    public function FindAmounts()
    {
        $SQL = "Select IFNULL(Sum(factorproducts . Amount), 0) as Amount from factorproducts WHERE  PaymentStatus = 1 AND Status != 3 AND Status != 4";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Amount'];
        }
    }

    public function FindAmountOfThisDate($date)
    {
        $SQL = "Select IFNULL(Sum(factorproducts . Amount), 0) as Amount from factorproducts WHERE  PaymentStatus = 1 AND Status != 3 AND Status != 4 AND factorproducts . Date LIKE '%$date%'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Amount'];
        }
    }

    public function FullFill()
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . RefId, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->RefId = $row['RefId'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->City = $row['City'];
            $factorproduct->Factor->Customer->Address = $row['Address'];
            $factorproduct->Factor->Customer->Estate = $row['Estate'];
            $factorproduct->Factor->Customer->Phone = $row['Phone'];
            $factorproduct->Factor->Customer->Mobile = $row['Mobile'];
            $factorproduct->Factor->Customer->PostCode = $row['PostCode'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Color = $row['Color'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function LimitedFill($limit)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . RefId, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId Where PaymentStatus != 0 AND PaymentStatus != 3 AND PaymentStatus != 4 ORDER BY factorproducts . FactorProductId DESC Limit $limit";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function FFill()
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . RefId, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Email , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId Where PaymentStatus = 0 OR PaymentStatus = 3 OR Status = 4 ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function Search($search_query)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . Amount ,  factorproducts . ShippingMethod, factorproducts . Services , factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment, factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId  Inner Join customers On factors . Customer = customers . CustomerId  Inner Join products On factorproducts . Product = products . ProductId $search_query AND PaymentStatus != 0 AND PaymentStatus != 3 AND Status != 4 ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function Search2($search_query)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . Amount ,  factorproducts . ShippingMethod, factorproducts . Services , factorproducts . PaymentStatus, factorproducts . PaymentMethod, factorproducts . Comment, factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId  Inner Join customers On factors . Customer = customers . CustomerId  Inner Join products On factorproducts . Product = products . ProductId $search_query AND (PaymentStatus = 0 OR PaymentStatus = 3 OR Status = 4) ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function FillByCode($code)
    {
        $SQL = "Select factorproducts . FactorProductId , factorproducts . TraceCode, factorproducts . RefId, factorproducts . Amount, factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus , factorproducts . PaymentMethod, factorproducts . Comment, factorproducts . Time ,factorproducts . Coupon, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count , customers . Name as CustomerName , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId, customers . Phone, customers . Mobile, customers . Email, customers . PostCode , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image ,  products . Brand as ProductBrand , products . Downloadable , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId  Inner Join customers On factors . Customer = customers . CustomerId  Inner Join products On factorproducts . Product = products . ProductId Where TraceCode = $code ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->RefId = $row['RefId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Product->Brand->LogoId = $row['ProductBrand'];
            $factorproduct->Product->Downloadable = $row['Downloadable'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->City = $row['City'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->Factor->Customer->Address = $row['Address'];
            $factorproduct->Factor->Customer->Estate = $row['Estate'];
            $factorproduct->Factor->Customer->Phone = $row['Phone'];
            $factorproduct->Factor->Customer->Mobile = $row['Mobile'];
            $factorproduct->Factor->Customer->Email = $row['Email'];
            $factorproduct->Factor->Customer->PostCode = $row['PostCode'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Color = $row['Color'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function FindOneCustomerFactors($id)
    {
        $SQL = "Select factorproducts . FactorProductId,factorproducts . Coupon , factorproducts . Amount ,factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus , factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time , factorproducts . TraceCode, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count ,customers . CustomerId, customers . Name as CustomerName , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId Where customers . CustomerId = $id AND Status != 4 AND PaymentStatus != 0  ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->City = $row['City'];
            $factorproduct->Factor->Customer->Address = $row['Address'];
            $factorproduct->Factor->Customer->Estate = $row['Estate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Color = $row['Color'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function FindOneCustomerFactors2($id)
    {
        $SQL = "Select factorproducts . FactorProductId,factorproducts . Coupon , factorproducts . Amount ,factorproducts . ShippingMethod, factorproducts . Services, factorproducts . PaymentStatus , factorproducts . PaymentMethod, factorproducts . Comment , factorproducts . Time , factorproducts . TraceCode, factorproducts . Status, factorproducts . Guarantee , factorproducts . Color , factorproducts . Date , factorproducts . Count ,customers . CustomerId, customers . Name as CustomerName , customers . Address , customers . Family , customers . Estate , customers . City , customers . CustomerId , factorproducts . Price , products . ProductId , products . Name as ProductName , products . LatinName , products . Description , products . Image , factors . FactorId ,factors . Customer,factors . Date as FDate From factorproducts Inner Join factors On factorproducts . Factor = factors . FactorId Inner Join customers On factors . Customer = customers . CustomerId   Inner Join products On factorproducts . Product = products . ProductId Where customers . CustomerId = $id  ORDER BY factorproducts . FactorProductId DESC";
        $results = $this->da->execSelect($SQL);
        $factorproducts = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $factorproduct = new FactorProduct();
            $factorproduct->FactorProductId = $row['FactorProductId'];
            $factorproduct->Product->ProductId = $row['ProductId'];
            $factorproduct->PaymentStatus = $row['PaymentStatus'];
            $factorproduct->Product->Name = $row['ProductName'];
            $factorproduct->TraceCode = $row['TraceCode'];
            $factorproduct->PaymentMethod = $row['PaymentMethod'];
            $factorproduct->Comment = $row['Comment'];
            $factorproduct->Time = $row['Time'];
            $factorproduct->Services = $row['Services'];
            $factorproduct->ShippingMethod = $row['ShippingMethod'];
            $factorproduct->Product->LatinName = $row['LatinName'];
            $factorproduct->Product->Description = $row['Description'];
            $factorproduct->Product->Image = $row['Image'];
            $factorproduct->Factor->FactorId = $row['FactorId'];
            $factorproduct->Factor->Date = $row['FDate'];
            $factorproduct->Factor->Customer->CustomerId = $row['CustomerId'];
            $factorproduct->Factor->Customer->Name = $row['CustomerName'];
            $factorproduct->Amount = $row['Amount'];
            $factorproduct->Factor->Customer->Family = $row['Family'];
            $factorproduct->Factor->Customer->City = $row['City'];
            $factorproduct->Factor->Customer->Address = $row['Address'];
            $factorproduct->Factor->Customer->Estate = $row['Estate'];
            $factorproduct->Date = $row['Date'];
            $factorproduct->Price = $row['Price'];
            $factorproduct->Coupon = $row['Coupon'];
            $factorproduct->Count = $row['Count'];
            $factorproduct->Status = $row['Status'];
            $factorproduct->Color = $row['Color'];
            $factorproduct->Guarantee = $row['Guarantee'];
            $factorproducts[$i] = $factorproduct;
            $i++;
        }
        return $factorproducts;
    }

    public function Notification()
    {
        $SQL = "Select Status From factorproducts where Status = 0 AND PaymentStatus != 0 AND PaymentStatus != 3 AND Status != 4 ";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        return $i;
    }

    /*
     * @method gregorian_to_jalali ($g_y, $g_m, $g_d,$str)       return gregorian to jalali converted date 
     * @method jalali_to_gregorian($j_y, $j_m, $j_d,$str)        return jalali to gregorian converted date 
     * 
     * @author     Roozbeh Baabakaan
     * @version    SVN: $Id: gregorian_jalali 1 2012-12-20 19:07:0 
     */


}
