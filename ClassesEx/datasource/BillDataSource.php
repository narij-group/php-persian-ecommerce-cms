<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Bill.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";


/**
 * Created by PhpStorm.
 * User: kami
 * Date: 10/25/2017
 * Time: 1:47 AM
 */
class BillDataSource
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

    public function Insert(Bill $bill)
    {
        $sql = "Insert Into bills(`Code`,Comment,Date,TraceCode,Bank,Status) VALUES ('" . $bill->getCode() . "','" . $bill->getComment() . "' ,'" . $bill->getDate() . "' , " . $bill->getTraceCode() . ", '" . $bill->getBank() . "', " . $bill->getStatus() . ")";
        $this->da->exec($sql);
    }

    public function Update(Bill $bill)
    {
        $sql = "Update bills Set Status = " . $bill->getStatus() . ",Code = '" . $bill->getCode() . "',Comment = '" . $bill->getComment() . "',Date = '" . $bill->getDate() . "',Bank = '" . $bill->getBank() . "',TraceCode = " . $bill->getTraceCode() . " Where BillId=" . $bill->getBillId() . "";
        $this->da->exec($sql);
    }

    public function Delete($id)
    {
        $sql = "Delete From bills Where BillId= " . $id;
        $this->da->exec($sql);
    }

    public function UpdateStatus(Bill $bill, $num)
    {
        $sql = "Update bills Set Status = $num Where BillId=" . $bill->getBillId() . "";
        $this->da->exec($sql);
    }

    public function FindOneBillBasedOnId($id)
    {
        $sql = "Select * From bills Where BillId=" . $id;
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->setBillId($row['BillId']);
            $bill->setComment($row['Comment']);
            $bill->setDate($row['Date']);
            $bill->setCode($row['Code']);
            $bill->setTraceCode($row['TraceCode']);
            $bill->setStatus($row['Status']);
            $bill->setBank($row['Bank']);
            return $bill;
        }
    }

    public function FindByCode($code)
    {
        $sql = "Select * From bills Where TraceCode=" . $code;
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->setBillId($row['BillId']);
            $bill->setComment($row['Comment']);
            $bill->setDate($row['Date']);
            $bill->setCode($row['Code']);
            $bill->setTraceCode($row['TraceCode']);
            $bill->setStatus($row['Status']);
            $bill->setBank($row['Bank']);
            return $bill;
        }
    }

    public function GetBillsForProduct($id)
    {
        $sql = "Select * From bills Where TraceCode=" . $id;
        $results = $this->da->execSelect($sql);
        $bills = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $bill = new Bill();
            $bill->setBillId($row['BillId']);
            $bill->setComment($row['Comment']);
            $bill->setDate($row['Date']);
            $bill->setCode($row['Code']);
            $bill->setTraceCode($row['TraceCode']);
            $bill->setStatus($row['Status']);
            $bill->setBank($row['Bank']);
            $bills[$i] = $bill;
            $i++;
        }
        return $bills;
    }

}