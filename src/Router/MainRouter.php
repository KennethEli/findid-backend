<?php
  namespace App\Router;

  class MainRouter {
    private array $routes = [];
    private string $uri;
    private string $method;
    private string $path;

    private  function __construct() {
      $this -> uri = $_SERVER['REQUEST_URI'];
      $this -> method = $_SERVER['REQUEST_METHOD'];
      $this -> path = parse_url($this -> uri, PHP_URL_PATH);
    }

    public static function init () :MainRouter  {
      return new self();
    }


    public function get(string $uri, $controller ,callable $callback):void {
      if($this -> method === 'GET'  &&  $uri === $this -> path) {
        $this -> addRoute($uri, $controller, $callback, $this -> method);      }
    }
    public function post(string $uri, $controller ,callable $callback) :void {
      if($this -> method === 'POST'  &&  $uri === $this -> path) { 
        $this -> addRoute($uri, $controller, $callback, $this -> method);
      }
    }
    public function put(string $uri, $controller ,callable $callback) :void {
      if($this -> method === 'PUT'  &&  $uri === $this -> path) {
        $this -> addRoute($uri, $controller, $callback, $this -> method);      }
    }
    public function patch(string $uri, $controller ,callable $callback) :void {
      if($this -> method === 'PATCH'  &&  $uri === $this -> path) {
        $this -> addRoute($uri, $controller, $callback, $this -> method);      }
    }
    public function delete(string $uri, $controller ,callable $callback) :void {
      if($this -> method === 'DELETE'  &&  $uri === $this -> path) {
        $this -> addRoute($uri, $controller, $callback, $this -> method);
        // call_user_func([$controller , $callback]);
      }
    }
    private function addRoute(string $uri, $controller, callable $callback, string $method) :void {
      $this -> routes[] = [
        'method' => $method,
        'uri' => $uri,
        'controller' => $controller,
        'callable' => $callback
      ];
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
