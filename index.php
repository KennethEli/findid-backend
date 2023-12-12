<?php
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

