<?php

require_once 'DataAccess.inc';

class Bill {

    public $BillId;
    public $Comment;
    public $Code;
    public $Date;
    public $TraceCode;
    public $Status;
    public $Bank;

    public function __construct() {
        $this->BillId = 0;
        $this->Comment = "";
        $this->Code = "";
        $this->Date = "";
        $this->TraceCode = 0;
        $this->Status = 0;
        $this->Bank = "";
    }

    public function Insert() {
        $SQL = "Insert Into bills(`Code`,Comment,Date,TraceCode,Bank,Status) VALUES ('" . $this->Code . "','" . $this->Comment . "' ,'" . $this->Date . "' , " . $this->TraceCode . ", '" . $this->Bank . "', " . $this->Status . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update bills Set Status = ".$this->Status.",Code = '".$this->Code."',Comment = '".$this->Comment."',Date = '".$this->Date."',Bank = '".$this->Bank."',TraceCode = ".$this->TraceCode." Where BillId=" . $this->BillId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From bills Where BillId= " . $this->BillId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function UpdateStatus($num) {
        $SQL = "Update bills Set Status = $num Where BillId=" . $this->BillId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneBill() {
        $SQL = "Select * From bills Where BillId=" . $this->BillId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->BillId = $row['BillId'];
            $bill->Comment = $row['Comment'];
            $bill->Date = $row['Date'];
            $bill->Code = $row['Code'];
            $bill->TraceCode = $row['TraceCode'];
            $bill->Status = $row['Status'];
            $bill->Bank = $row['Bank'];
            return $bill;
        }
    }
    public function FindByCode($code) {
        $SQL = "Select * From bills Where TraceCode=" . $code;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->BillId = $row['BillId'];
            $bill->Comment = $row['Comment'];
            $bill->Date = $row['Date'];
            $bill->Code = $row['Code'];
            $bill->TraceCode = $row['TraceCode'];
            $bill->Status = $row['Status'];
            $bill->Bank = $row['Bank'];
            return $bill;
        }
    }

    public function GetBillsForProduct($id) {
        $SQL = "Select * From bills Where TraceCode=" . $id;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $bills = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->BillId = $row['BillId'];
            $bill->Comment = $row['Comment'];
            $bill->Date = $row['Date'];
            $bill->Code = $row['Code'];
            $bill->TraceCode = $row['TraceCode'];
            $bill->Status = $row['Status'];
            $bill->Bank = $row['Bank'];
            $bills[$i] = $bill;
            $i++;
        }
        return $bills;
    }
}
