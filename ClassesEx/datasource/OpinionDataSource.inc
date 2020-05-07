<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Opinion.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class OpinionDataSource
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

    public function Insert(Opinion $opinion)
    {
        $SQL = "Insert Into opinions(`Customer`,Value,ProductId,Rate,Date) Values (" . $opinion->Customer . ",'" . $opinion->Value . "' , " . $opinion->ProductId . " , " . $opinion->Rate . ", '" . $opinion->Date . "')";
        $this->da->exec($SQL);
    }

    public function Activate($id)
    {
        $SQL = "Update opinions Set Activated = 1 Where OpinionId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function DissActivate($id)
    {
        $SQL = "Update opinions Set Activated = 2 Where OpinionId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From opinions Where OpinionId= " . $id;
        $this->da->exec($SQL);
    }


    public function DeleteOpinionsRelatedToProduct($id)
    {
        $SQL = "Select * From opinions Where ProductId=" . $id;
        $this->da->exec($SQL);
    }

    public function DeleteOpinionsRelatedToCustomer($id)
    {
        $SQL = "DELETE From opinions Where Customer=" . $id;
        $this->da->exec($SQL);
    }


    public function FindOneOpinionBasedOnId($id)
    {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where OpinionId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Value = $row['Value'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            return $opinion;
        }
    }

    public function isCustomerVotedAlready($customer, $product)
    {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $product . " AND Customer = " . $customer;
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        if ($i == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function GetOpinionsForProduct($id)
    {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $id;
        $results = $this->da->execSelect($SQL);
        $opinions = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Value = $row['Value'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            $opinions[$i] = $opinion;
            $i++;
        }
        return $opinions;
    }

    public function GetThisCustomerOpinions($id)
    {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where Customer=" . $id . " ORDER BY OpinionId DESC";
        $results = $this->da->execSelect($SQL);
        $opinions = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Value = $row['Value'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            $opinions[$i] = $opinion;
            $i++;
        }
        return $opinions;
    }

    public function GetRateForProduct($id)
    {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $id . " AND Activated = 1";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        $rate = 0;
        while ($row = mysqli_fetch_array($results)) {
            $rate += $row['Rate'];
            $i++;
        }
        if ($i != 0) {
            return $rate / $i;
        } else {
            return 1;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer ORDER BY OpinionId DESC ";
        $results = $this->da->execSelect($SQL);
        $opinions = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Value = $row['Value'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            $opinions[$i] = $opinion;
            $i++;
        }
        return $opinions;
    }

    public function CFill($product)
    {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer WHERE ProductId = " . $product . " AND Activated = 1 ORDER BY OpinionId DESC ";
        $results = $this->da->execSelect($SQL);
        $opinions = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Value = $row['Value'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            $opinions[$i] = $opinion;
            $i++;
        }
        return $opinions;
    }

    public function LimitedFill($limit)
    {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer ORDER BY OpinionId DESC Limit $limit";
        $results = $this->da->execSelect($SQL);
        $opinions = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $opinion = new Opinion();
            $opinion->OpinionId = $row['OpinionId'];
            $opinion->Value = $row['Value'];
            $opinion->Rate = $row['Rate'];
            $opinion->Date = $row['Date'];
            $opinion->Customer->CustomerId = $row['CustomerId'];
            $opinion->Customer->Name = $row['Name'];
            $opinion->Customer->Family = $row['Family'];
            $opinion->Activated = $row['Activated'];
            $opinion->ProductId = $row['ProductId'];
            $opinions[$i] = $opinion;
            $i++;
        }
        return $opinions;
    }


    public function Notification()
    {
        $SQL = "Select Activated From opinions where Activated = 0 ";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        return $i;
    }

}
