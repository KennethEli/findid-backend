<?php

namespace App\Config;


class Database {

    private static ?Database $instance = null;
    private $conn;

    private function __construct () {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");

        try{
            $this -> conn = new \PDO($_ENV['DNS'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $this -> conn -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            echo "Connection failed: ". $e->getMessage();
        }
    }
    
    private function __clone() {
        //PREVENT CLASS FROM BEING CLONED
    }
    
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance  = new self();
        }
        return self::$instance;
    }

    public function getConn() {
        return $this -> conn;
    }

    public static function connect() {
        if(self::$instance === null) {
            self::$instance  = new self();
        }
    }

   
}



