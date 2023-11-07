<?php
require_once 'config.php';
class Db
{
    public static $connection;
    public function __construct()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
            self::$connection->set_charset(DB_CHARSET);
        }
        // if (self::$connection->connect_error) {
        //     die("Loi ket noi DB");
        // } else {
        //     echo "ket noi thanh cong!";
        // }

        return self::$connection;
    }
}

//test
// $db = new Db();
