<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Online.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class OnlineDataSource {


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

    public function Insert(Online $online) {
        $SQL = "Insert Into onlines(`Session`,Time) Values ('" . $online->Session . "' , " . $online->Time . ")";
        $this->da->exec($SQL);
    }

    public function Update(Online $online) {
        $SQL = "Update onlines Set Time=" . $online->Time . " , Session='" . $online->Session . "' Where OnlineId=" . $online->OnlineId . "";
        $this->da->exec($SQL);
    }

    public function FindOneOnlineBasedOnId($id) {
        $SQL = "Select * From onlines Where OnlineId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $online = new Online();
            $online->OnlineId = $row['OnlineId'];
            $online->Session = $row['Session'];
            $online->Time = $row['Time'];
            return $online;
        }
    }

    public function Fill() {
        $SQL = "Select * From `onlines`";
        $results = $this->da->execSelect($SQL);
        $onlines = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $online = new Online();
            $online->OnlineId = $row['OnlineId'];
            $online->Session = $row['Session'];
            $online->Time = $row['Time'];
            $onlines[$i] = $online;
            $i++;
        }
        return $onlines;
    }

    public function checkSession($session) {
        $SQL = "Select * From onlines Where Session='" . $session . "'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $online = new Online();
            $online->OnlineId = $row['OnlineId'];
            $online->Session = $row['Session'];
            $online->Time = $row['Time'];
            return $online;
        }
    }

}
