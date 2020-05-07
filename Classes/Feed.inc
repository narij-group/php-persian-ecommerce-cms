<?php

require_once 'DataAccess.inc';

class Feed {

    public $FeedId;
    public $Email;

    public function __construct() {
        $this->FeedId = 0;
        $this->Email = "";
    }

    public function Insert() {

        $SQL = "Insert Into feeds(`Email`) Values ('" . $this->Email . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update feeds Set `Email`='" . $this->Email . "' Where FeedId=" . $this->FeedId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From feeds Where FeedId = " . $this->FeedId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from feeds ORDER BY FeedId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $feeds = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $feed = new Feed();
            $feed->FeedId = $row['FeedId'];
            $feed->Email = $row['Email'];
            $feeds[$i] = $feed;
            $i++;
        }
        return $feeds;
    }

    public function FindOneFeed() {
        $SQL = "Select * from feeds where FeedId = ". $this->FeedId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $feed = new Feed();
            $feed->FeedId = $row['FeedId'];
            $feed->Email = $row['Email'];            
            return $feed;
        }        
    }

}
