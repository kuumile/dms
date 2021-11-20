<?php
class Database {

    private static $con;
    private $connection;

    private function __construct() {
        $this->connection = new MySQLi('localhost','root','Simon21061989@','avitsdms');
    }

    public function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
        if (self::$con == null) {
            self::$con = new Database();
        }
        return self::$con->connection;
    }
}