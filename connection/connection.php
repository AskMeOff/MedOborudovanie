<?php


error_reporting(E_ALL);
ini_set('display_errors', 'on');

class ConnectionDB
{
    private $host = '172.19.6.64';
    private $user = 'user';
    private $password = 'user';
    private $database = 'medOborudovanie';
    public $con;

    public function __construct()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database) or die("Ошибка подключения " . mysqli_error($this->con));
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }

    function executeQuery($query)
    {
        $result = mysqli_query($this->con, $query) or die("ошибка" . mysqli_error($this->con));
        return $result;
    }

    function getRowResult($result)
    {
        return mysqli_fetch_assoc($result);
    }

    function getNumRows($result)
    {
        return mysqli_num_rows($result);
    }
}

$connectionDB = new ConnectionDB();




