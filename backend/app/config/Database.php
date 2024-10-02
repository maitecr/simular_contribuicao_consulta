<?php

class Database {

    function __construct() {
        self::connect();
    }

    private static $host = 'localhost';
    private static $db_name = 'postgres';
    private static $username = 'postgres';
    private static $password = 'postgres';
    private static $port = '5432';
    private static $conn = null;


    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db_name, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Conexão bem-sucedida!";
            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        }
        return self::$conn;
    }    
}


