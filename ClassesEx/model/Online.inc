<?php


/**
 * Class Online
 */
class Online {

    /**
     * @var int
     */
    public $OnlineId;
    /**
     * @var string
     */
    public $Session;
    /**
     * @var int
     */
    public $Time;

    /**
     * @return int
     */
    public function getOnlineId()
    {
        return $this->OnlineId;
    }

    /**
     * @param int $OnlineId
     */
    public function setOnlineId($OnlineId)
    {
        $this->OnlineId = $OnlineId;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * @param string $Session
     */
    public function setSession($Session)
    {
        $this->Session = $Session;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->Time;
    }

    /**
     * @param int $Time
     */
    public function setTime($Time)
    {
        $this->Time = $Time;
    }

    /**
     * Online constructor.
     */
    public function __construct() {
        $this->OnlineId = 0;
        $this->Session = "";
        $this->Time = 0;
    }


}
