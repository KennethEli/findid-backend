<?php

require('../config/database.php');

require('../controller/auth.php');

$auth_controller = new AuthController($conn);

//routing
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($uri, PHP_URL_PATH);

switch($path) {
    //register route
    case '/findid-backend/api/v1/register.php':
        if($method === 'POST') {
            echo "POST Register";
            $auth_controller->post_register();
        }
        break;
    
    //login route
    case '/findid-backend/api/api_v1/login.php';
        if($method === 'GET') {
            $auth_controller->get_login();
        }
        break;
    default:
        header('http/1.1 404 not found');
        echo json_encode(['error' => 'Not Found']);
        break;
}