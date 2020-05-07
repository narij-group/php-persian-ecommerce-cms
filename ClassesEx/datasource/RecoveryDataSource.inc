<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Recovery.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class RecoveryDataSource
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

    public function Insert(Recovery $recovery)
    {
        $SQL = "Insert Into recovery(`Customer`,Time) Values (" . $recovery->Customer . " , ".time().")";
        $this->da->exec($SQL);
    }

    public function Update(Recovery $recovery)
    {
        $SQL = "Update recovery Set Time = ".$recovery->Time." , Customer=" . $recovery->Customer . " Where RecoveryId=" . $recovery->RecoveryId . "";
        $this->da->exec($SQL);
    }

    public function FindOneRecoveryBasedOnId($id)
    {
        $SQL = "Select * From recovery Where RecoveryId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $recovery = new Recovery();
            $recovery->RecoveryId = $row['RecoveryId'];
            $recovery->Customer = $row['Customer'];
            $recovery->Time = $row['Time'];
            return $recovery;
        }
    }
    public function FindOneRecoveryByCustomer($customer)
    {
        $SQL = "Select * From recovery Where Customer=" . $customer;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $recovery = new Recovery();
            $recovery->RecoveryId = $row['RecoveryId'];
            $recovery->Customer = $row['Customer'];
            $recovery->Time = $row['Time'];
            return $recovery;
        }
    }

    public function isUserAllowed(Recovery $recovery)
    {
        $time = time() - 86400;
        $SQL = "Select * From recovery Where Customer = ".$recovery->Customer." AND Time > " . $time . "";
        $results = $this->da->execSelect($SQL);
        $r = false;
        while ($row = mysqli_fetch_array($results)) {
            $r = true;
        }
        return $r;
    }

    public function Fill()
    {
        $SQL = "Select * From `recovery` ORDER BY Time DESC";
        $results = $this->da->execSelect($SQL);
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
