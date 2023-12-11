<?php
  namespace App\Router;

  class MainRouter {
    private array $routes = [];
    private string $uri;
    private string $method;
    private string $path;

    public function __construct() {
      $this -> uri = $_SERVER['REQUEST_URI'];
      $this -> method = $_SERVER['REQUEST_METHOD'];
      $this -> path = parse_url($this -> uri, PHP_URL_PATH);
    }


    public function get(string $uri, $controller ,callable $callback) {
      if($this -> method === 'GET'  &&  $uri === $this -> path) {
        call_user_func([$controller , $callback]);
      }
    }
    public function post(string $uri, $controller ,callable $callback) {
      if($this -> method === 'POST'  &&  $uri === $this -> path) {
        call_user_func([$controller , $callback]);
      }
    }
    public function put(string $uri, $controller ,callable $callback) {
      if($this -> method === 'PUT'  &&  $uri === $this -> path) {
        call_user_func([$controller , $callback]);
      }
    }
    public function patch(string $uri, $controller ,callable $callback) {
      if($this -> method === 'PATCH'  &&  $uri === $this -> path) {
        call_user_func([$controller , $callback]);
      }
    }
    public function delete(string $uri, $controller ,callable $callback) {
      if($this -> method === 'DELETE'  &&  $uri === $this -> path) {
        call_user_func([$controller , $callback]);
      }
    }
    public function match() :void {
      foreach($this -> routes as $route) {
        [$routeMethod, $routePath, $controller, $callback] = $route;
        if($this -> method === $routeMethod && $this -> uri === $routePath) {
          $this -> invokeControllerMethod($controller, $callback);
        }
      }
    }
    private function invokeControllerMethod ($controller, callable $callback) :void {
    call_user_func([$controller, $callback]);
    }
  }
