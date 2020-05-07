<?php

require_once 'DataAccess.inc';

class Online {

    public $OnlineId;
    public $Session;
    public $Time;

    public function __construct() {
        $this->OnlineId = 0;
        $this->Session = "";
        $this->Time = 0;
    }

    public function Insert() {
        $SQL = "Insert Into onlines(`Session`,Time) Values ('" . $this->Session . "' , " . $this->Time . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update onlines Set Time=" . $this->Time . " , Session='" . $this->Session . "' Where OnlineId=" . $this->OnlineId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneOnline() {
        $SQL = "Select * From onlines Where OnlineId=" . $this->OnlineId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $online = new Online();
            $online->OnlineId = $row['OnlineId'];
            $online->Session = $row['Session'];
            $online->Time = $row['Time'];
            return $online;
        }
    }

}
