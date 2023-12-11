<?php
    namespace App\Api;
    
    
    class ApiV1 {
        private $authController;
        
        public function __construct() {
            try {
                \App\Config\Database::connect();
                $this -> authController = new  \App\Controller\AuthController();

            }catch (\Exception $e) {
                echo ''. $e->getMessage() .'<br>';
            }
        }

        public function getV1 () {
        //routing
        try {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];
            $path = parse_url($uri, PHP_URL_PATH);
            
            switch($path) {
                //register route
                case '/findid-backend/api/v1/register.php':
                    if($method === 'POST') {
                        $this->authController->post_register();
                    }
                    break;
                
                //login route
                case '/findid-backend/api/v1/login.php';
                    if($method === 'POST') {
                        $this->authController->post_login();
                    }
                    break;
                default:
                    header('http/1.1 404 not found');
                    echo json_encode(['status' => 'Error', 'message' => 'Not Found!']);
                    break;
            }

        } catch(\Exception $e){
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];

            header("Content-Type: application/json");
            echo json_encode($response);
        }

    }
}
