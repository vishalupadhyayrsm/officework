<?php
require "config.php";
class Database
{

    private $host = HOSTNAME;
    private $db_name = DB;
    private $username = USERNAME;
    private $password = PASSWORD;

    public $conn;

    public function dbConnection()
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

$servername = HOSTNAME;
$username = USERNAME;
$password = PASSWORD;
$dbname = DB;

// echo $username;

try {
    $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Successfully Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
