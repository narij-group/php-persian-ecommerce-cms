<?php

class SMS
{
    public $USERNAME;  // your username (fill it with your username)
    public $PASSWORD; // your password (fill it with your password)
    public $senderNumber; // [FILL] sender number ; which is your 3000xxx number
    public $recipientNumber; // [FILL] recipient numb
    public $message; // [FILL] recipient numb

    public function __construct()
    {
        $this->USERNAME = "09113334886";
        $this->PASSWORD = "72514959";
        $this->senderNumber = "50002060388143";
        $this->recipientNumber = "";
        $this->message = "";
    }


    // base http url
    private $BASE_HTTP_URL = "http://www.sibsms.com/APISend.aspx?";

    public function enqueueSample()
    {
        $url = $this->BASE_HTTP_URL .
            "Username=" . $this->USERNAME . "&Password=" . $this->PASSWORD .
            "&From=" . $this->senderNumber . "&To=" . $this->recipientNumber .
            "&Text=" . $this->message;
        $result = $this->call($url);
    }

    private function call($url)
    {
        return file_get_contents($url);
    }
}
