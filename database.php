<?php
require 'config.php';

class DB
{
    private $conn;

    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        try {
            $this->conn = new PDO(DB_HOST, DB_USER, DB_PASSWORD);

            return $this->conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

$db = new DB;
$conn = $db->connection();
