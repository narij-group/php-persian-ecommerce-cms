<?php

/**
 * Class SMS
 */
class SMS
{
    /**
     * @var string
     */
    public $USERNAME;  // your username (fill it with your username)
    /**
     * @var string
     */
    public $PASSWORD; // your password (fill it with your password)
    /**
     * @var string
     */
    public $senderNumber; // [FILL] sender number ; which is your 3000xxx number
    /**
     * @var string
     */
    public $recipientNumber; // [FILL] recipient numb
    /**
     * @var string
     */
    public $message;

    /**
     * @return string
     */
    public function getUSERNAME()
    {
        return $this->USERNAME;
    }

    /**
     * @param string $USERNAME
     */
    public function setUSERNAME($USERNAME)
    {
        $this->USERNAME = $USERNAME;
    }

    /**
     * @return string
     */
    public function getPASSWORD()
    {
        return $this->PASSWORD;
    }

    /**
     * @param string $PASSWORD
     */
    public function setPASSWORD($PASSWORD)
    {
        $this->PASSWORD = $PASSWORD;
    }

    /**
     * @return string
     */
    public function getSenderNumber()
    {
        return $this->senderNumber;
    }

    /**
     * @param string $senderNumber
     */
    public function setSenderNumber($senderNumber)
    {
        $this->senderNumber = $senderNumber;
    }

    /**
     * @return string
     */
    public function getRecipientNumber()
    {
        return $this->recipientNumber;
    }

    /**
     * @param string $recipientNumber
     */
    public function setRecipientNumber($recipientNumber)
    {
        $this->recipientNumber = $recipientNumber;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * SMS constructor.
     */
    public function __construct()
    {
        $this->USERNAME = "09113334886";
        $this->PASSWORD = "72514959";
        $this->senderNumber = "50002060388143";
        $this->recipientNumber = "";
        $this->message = "";
    }


    // base http url
    /**
     * @var string
     */
    public $BASE_HTTP_URL = "http://www.sibsms.com/APISend.aspx?";

    /**
     *
     */
    public function enqueueSample()
    {
        $url = $this->BASE_HTTP_URL .
            "Username=" . $this->USERNAME . "&Password=" . $this->PASSWORD .
            "&From=" . $this->senderNumber . "&To=" . $this->recipientNumber .
            "&Text=" . $this->message;
        $result = $this->call($url);
    }

    /**
     * @param $url
     * @return string
     */
    public function call($url)
    {
        return file_get_contents($url);
    }
}
