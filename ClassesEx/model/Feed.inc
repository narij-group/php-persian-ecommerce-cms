<?php

/**
 * Class Feed
 */
class Feed {

    /**
     * @var int
     */
    public $FeedId;
    /**
     * @var string
     */
    public $Email;

    /**
     * @return int
     */
    public function getFeedId()
    {
        return $this->FeedId;
    }

    /**
     * @param int $FeedId
     */
    public function setFeedId($FeedId)
    {
        $this->FeedId = $FeedId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }


    /**
     * Feed constructor.
     */
    public function __construct() {
        $this->FeedId = 0;
        $this->Email = "";
    }


}
