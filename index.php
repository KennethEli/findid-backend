<?php
require_once __DIR__ . '/vendor/autoload.php';

  try {
    $api_v1 = new \App\Api\ApiV1();
    $api_v1->getV1();

  } catch (\Throwable $e) {
      echo ''. $e->getMessage() .'<br>';
  }

