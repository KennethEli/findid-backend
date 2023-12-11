<?php

  class Tangent {
    private static ?\App\Router\MainRouter $router = null;

    public function __construct() {
      $this->router = new \App\Router\MainRouter();
    }

    public static function Router() {
      if (self::$router === null) {
        self::$router = new \App\Router\MainRouter();
      }
      return self::$router;
    }

    public function use($router) {
      $router -> match();
    }
  }