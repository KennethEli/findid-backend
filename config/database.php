<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

try{
    $dsn = "mysql:host=localhost;dbname=foundid;
    ssl-ca=path/to/ca.pem;ssl-cert=path/to/client-cert.pem;
    ssl-key=path/to/client-key;";
    $username = "root";
    $password = "";
    $conn = new PDO($dsn, $username, $password);
    $domain = 'localhost/findid-backend';
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed: ". $e->getMessage();
}
?>