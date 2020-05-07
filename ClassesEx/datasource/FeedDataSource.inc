<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Feed.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class FeedDataSource
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

    public function Insert(Feed $feed)
    {
        $SQL = "Insert Into feeds(`Email`) Values ('" . $feed->getEmail() . "')";
        $this->da->exec($SQL);
    }

    public function Update(Feed $feed)
    {
        $SQL = "Update feeds Set `Email`='" . $feed->getEmail() . "' Where FeedId=" . $feed->getFeedId() . "";
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From feeds Where FeedId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from feeds ORDER BY FeedId DESC";
        $results = $this->da->execSelect($SQL);
        $feeds = array();
        while ($row = mysqli_fetch_array($results)) {
            $feed = new Feed();
            $feed->setFeedId($row['FeedId']);
            $feed->setEmail($row['Email']);
            $feeds[] = $feed;
        }
        return $feeds;
    }

    public function FindOneFeedBasedOnId($id)
    {
        $SQL = "Select * from feeds where FeedId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $feed = new Feed();
            $feed->setFeedId($row['FeedId']);
            $feed->setEmail($row['Email']);
            return $feed;
        }
    }

}
