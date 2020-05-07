<?php

require_once 'DataAccess.inc';
require_once 'Customer.inc';

class Opinion {

    public $OpinionId;
    public $Customer;
    public $Value;
    public $ProductId;
    public $Rate;
    public $Date;
    public $Activated;

    public function __construct() {
        $this->OpinionId = 0;
        $this->Customer = new Customer();
        $this->Value = "";
        $this->Date = "";
        $this->ProductId = 0;
        $this->Rate = 0;
        $this->Activated = 0;
    }

    public function Insert() {
        $SQL = "Insert Into opinions(`Customer`,Value,ProductId,Rate,Date) Values (" . $this->Customer . ",'" . $this->Value . "' , " . $this->ProductId . " , " . $this->Rate . ", '" . $this->Date . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Activate() {
        $SQL = "Update opinions Set Activated = 1 Where OpinionId=" . $this->OpinionId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function DissActivate() {
        $SQL = "Update opinions Set Activated = 2 Where OpinionId=" . $this->OpinionId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From opinions Where OpinionId= " . $this->OpinionId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneOpinion() {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where OpinionId=" . $this->OpinionId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function isCustomerVotedAlready() {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $this->ProductId . " AND Customer = " . $this->Customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function GetOpinionsForProduct($id) {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $id;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    public function GetThisCustomerOpinions($id) {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where Customer=" . $id ." ORDER BY OpinionId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function GetRateForProduct($id) {
        $SQL = "Select * From opinions Inner Join customers on CustomerId = Customer Where ProductId=" . $id ." AND Activated = 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function Fill() {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer ORDER BY OpinionId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    public function CFill() {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer WHERE ProductId = ".$this->ProductId." AND Activated = 1 ORDER BY OpinionId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    
    public function LimitedFill($limit) {
        $SQL = "Select * From `opinions` Inner Join customers on CustomerId = Customer ORDER BY OpinionId DESC Limit $limit";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    
    
    
    public function Notification() {
        $SQL = "Select Activated From opinions where Activated = 0 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {            
            $i++;
        }
        return $i;
    }

}
