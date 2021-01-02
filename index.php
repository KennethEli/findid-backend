<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
  require_once __DIR__ . '/vendor/autoload.php';

  //Load environment variables
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
  $dotenv->load();


  try {
    $api_v1 = new \App\Api\ApiV1();
    $api_v1->getV1();

  } catch (\Throwable $e) {
        echo ''. $e->getMessage() .'<br>';
    }

  set_exception_handler(function (Throwable $e) {
    echo $e->getMessage() .'';
  });
