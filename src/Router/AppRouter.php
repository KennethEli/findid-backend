<?php
  $router = new \App\Router\MainRouter();
  $authController = new \App\Controller\AuthController();

  $router -> get("/", $authController , 'get_forget_password' );
  