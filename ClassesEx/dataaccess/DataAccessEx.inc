<?php


/**
 * Created by PhpStorm.
 * User: kami
 * Date: 1/17/2017
 * Time: 11:40 PM
 */
class DataAccessEx
{
    public $connection;
    private $host;
    private $user;
    private $password;
    private $database;

    function __construct()
    {
        $parse = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . "../../Configuration/connection.ini", FALSE);
        $this->host = $parse['host'];
        $this->user = $parse['user'];
        $this->password = $parse['password'];
        $this->database = $parse['database'];
    }


    public function open()
    {
        $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }

    public function exec($sql)
    {
        mysqli_query($this->connection, "set character_set_client='utf8'");
        mysqli_query($this->connection, "set character_set_results='utf8'");
        mysqli_query($this->connection, "set collation_connection='utf8_general_ci'");
        mysqli_query($this->connection, $sql);
        return mysqli_insert_id($this->connection);
    }

    public function execSelect($sql)
    {
        mysqli_query($this->connection, "set character_set_client='utf8'");
        mysqli_query($this->connection, "set character_set_results='utf8'");
        mysqli_query($this->connection, "set collation_connection='utf8_general_ci'");
        return mysqli_query($this->connection, $sql);
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}