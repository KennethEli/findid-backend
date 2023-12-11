<?php

namespace App\Config;


class Database {

    private static ?Database $instance = null;
    private $dns;
    private $domain;
    private $username;
    private $password;
    private $conn;

    private function __construct () {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");

        try{
            $this->dns = "mysql:host=localhost;dbname=foundid;
            ssl-ca=path/to/ca.pem;ssl-cert=path/to/client-cert.pem;
            ssl-key=path/to/client-key;";
            $this -> username = "root";
            $this -> password = "";
            $this -> conn = new \PDO($this -> dns, $this -> username, $this -> password);
            $this -> domain = 'localhost/findid-backend';
            $this -> conn -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            echo "Connection failed: ". $e->getMessage();
        }
    }
    
    private function __clone() {}
    
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



