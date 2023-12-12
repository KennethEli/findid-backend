<?php
  namespace App\Router;
  class Tangent {
    private static ?\App\Router\MainRouter $router = null;

    public function __construct() {
      $this->router = \App\Router\MainRouter::init();
    }

    public static function Router() {
      if (self::$router === null) {
        self::$router = \App\Router\MainRouter::init();
      }
      return self::$router;
    }

    public function use($router) {
      $router -> match();
    }
  }