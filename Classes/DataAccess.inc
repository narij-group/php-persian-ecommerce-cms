<?php

class DataAccess
{
    function __construct()
    {
        $parse = parse_ini_file(__DIR__ . "/../Configuration/connection.ini", FALSE);
        $this->host = $parse['host'];
        $this->user = $parse['user'];
        $this->password = $parse['password'];
        $this->database = $parse['database'];
    }


    public function execute($SQL)
    {
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
//        $con = mysqli_connect("127.0.0.1", "shop5_shop", "!@#$%^&*()", "shop5_digitalshop");
//        $con = mysqli_connect("127.0.0.1", "root", "", "Shop5_00001");
        mysqli_query($con, "set character_set_client='utf8'");
        mysqli_query($con, "set character_set_results='utf8'");
        mysqli_query($con, "set collation_connection='utf8_general_ci'");
        mysqli_query($con, $SQL);
        $id = mysqli_insert_id($con);
        mysqli_close($con);
        return $id;
    }

    public function executeSelect($SQL)
    {
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
//        $con = mysqli_connect("127.0.0.1", "shop5_shop", "!@#$%^&*()", "shop5_digitalshop");
//        $con = mysqli_connect("127.0.0.1", "root", "", "Shop5_00001");
        mysqli_query($con, "set character_set_client='utf8'");
        mysqli_query($con, "set character_set_results='utf8'");
        mysqli_query($con, "set collation_connection='utf8_general_ci'");
        $results = mysqli_query($con, $SQL);
        mysqli_close($con);
        return $results;
    }

}
