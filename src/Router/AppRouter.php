<?php
  $router = \App\Router\Tangent::Router();
  $authController = new \App\Controller\AuthController();

  $router -> get("/", $authController , 'get_forget_password' );
  