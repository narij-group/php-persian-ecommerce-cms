<?php

require_once 'DataAccess.inc';

class Recovery
{
    public $RecoveryId;
    public $Customer;
    public $Time;

    public function __construct()
    {
        $this->RecoveryId = 0;
        $this->Customer = "";
        $this->Time = 0;
    }

    public function Insert()
    {
        $SQL = "Insert Into recovery(`Customer`,Time) Values (" . $this->Customer . " , " . time() . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update recovery Set Time = " . $this->Time . " , Customer=" . $this->Customer . " Where RecoveryId=" . $this->RecoveryId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneRecovery()
    {
        $SQL = "Select * From recovery Where RecoveryId=" . $this->RecoveryId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $recovery = new Recovery();
            $recovery->RecoveryId = $row['RecoveryId'];
            $recovery->Customer = $row['Customer'];
            $recovery->Time = $row['Time'];
            return $recovery;
        }
    }

    public function FindOneRecoveryByCustomer()
    {
        $SQL = "Select * From recovery Where Customer=" . $this->Customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $recovery = new Recovery();
            $recovery->RecoveryId = $row['RecoveryId'];
            $recovery->Customer = $row['Customer'];
            $recovery->Time = $row['Time'];
            return $recovery;
        }
    }

    public function isUserAllowed($customer)
    {
        $time = time() - 86400;
        $SQL = "Select * From recovery Where Customer = " . $customer . " AND Time > " . $time . "";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $r = false;
        while ($row = mysqli_fetch_array($results)) {
            $r = true;
        }
        return $r;
    }

    public function Fill()
    {
        $SQL = "Select * From `recovery` ORDER BY Time DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $recoverys = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $recovery = new Recovery();
            $recovery->RecoveryId = $row['RecoveryId'];
            $recovery->Customer = $row['Customer'];
            $recovery->Time = $row['Time'];
            $recoverys[$i] = $recovery;
            $i++;
        }
        return $recoverys;
    }


}
