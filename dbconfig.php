<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database
{
    private $host = "127.0.0.1";
    private $port = "3306";
    private $db_name = "alumniidcards";
    private $username = "root";
    private $password = "";

    public $conn;

    public function dbConnection()
    {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}

$database = new Database();
$DB_con = $database->dbConnection();
?>
