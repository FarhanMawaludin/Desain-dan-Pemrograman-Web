<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "prakwebdb2";
    public $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
?>