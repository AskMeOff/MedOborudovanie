<?php


error_reporting(E_ALL);
ini_set('display_errors', 'on');

class ConnectionDB
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'medOborudovanie';
    public $con;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    public function __construct()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database) or die("Ошибка подключения " . mysqli_error($this->con));
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }

    public function escapeString($string) {
        return $this->con->real_escape_string($string);
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




