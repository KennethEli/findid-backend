<?php
  function jwt_encode(array $data) :string {
    return \Firebase\JWT\JWT::encode($data, $_ENV['JWT_SECRET'],'HS256');
  }

  function jwt_decode(string $jwt) :array {
    try {
      return \Firebase\JWT\JWT::decode($jwt,new \Firebase\JWT\Key( $_ENV['JWT_SECRET'],'HS256')) -> data;
    } catch (\Throwable $e) {
      echo 'Error: ' . $e -> getMessage();
    }
  }
  

