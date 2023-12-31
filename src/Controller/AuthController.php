<?php
namespace App\Controller;

class AuthController {
    private $conn;
    
    public function __construct() {
        $this -> conn = \App\Config\Database::getInstance() -> getConn();
    }

    /**
     * params()
     * return()
     * Registration Function
     */
    public function post_register()  {
        try {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $other_name = $_POST['other_name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $phone_number = $_POST['phone_number'];
            $location = $_POST['location'];
            $occupation = $_POST['occupation'];
            $momo_number = $_POST['momo_number'];
            $institution_name = $_POST['institution_name'];

            //check if password is same
            if ($_POST['password'] !== $_POST['confirm_password']) {
                http_response_code(401);
                throw new \Exception('Passwords do not matct');
            }
            
            // Check if username already exists
            $sql = "SELECT * FROM users WHERE email = :email AND username = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user) {
                http_response_code(403);
                throw new \Exception("user account or email already exists.");
            }


            // Create user account
            $sql = "INSERT INTO users (first_name, last_name, other_name, username, email, password, dob, gender, phone_number, location, occupation, momo_number, institution_name)
        VALUES (:first_name, :last_name, :other_name, :username, :email, :password, :dob, :gender, :phone_number, :location, :occupation, :momo_number, :institution_name)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':first_name', $first_name, \PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, \PDO::PARAM_STR);
            $stmt->bindParam(':other_name', $other_name, \PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
            $stmt->bindParam(':dob', $dob, \PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, \PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phone_number, \PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, \PDO::PARAM_STR);
            $stmt->bindParam(':occupation', $occupation, \PDO::PARAM_STR);
            $stmt->bindParam(':momo_number', $momo_number, \PDO::PARAM_STR);
            $stmt->bindParam(':institution_name', $institution_name, \PDO::PARAM_STR);
            $stmt->execute();

            header("Content-Type: application/json");

            $response = ['status' => 'success', 'message' => 'Account created successfully'];
            return json_encode($response);
        } catch (\PDOException $e) {
            http_response_code(500);
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            header("Content-Type: application/json");
            return json_encode($response);
        } catch (\Throwable $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];

            header("Content-Type: application/json");
            return json_encode($response);
        }
    }


    /**
     * 
     *
     *
     */
    public function post_login()
    {
        try {
            if( !isset($_POST['email']) || !isset($_POST['password'])){
                http_response_code(403);
                throw new \Exception('Invalid input');
            }
            $email = $_POST['email'];
            $password = $_POST['password'];

            //prepare sql statement
            $sql =  "SELECT * FROM users WHERE  email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->rowCount();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);


            //check if email provided exist 
            if (!$row > 0) {
                http_response_code(403);
                throw new \Exception("An account with this  email does not exist.");
            }

            //check if provided password is correct
            if (md5($password)!== $user["password"]) {
                http_response_code(403);
                throw new \Exception("Invalid Credentials");
            }
            // Set the response header to JSON
            header("Content-Type: application/json");

            //Generate Token
            $data = ['user_id' => $user['id'], 'email' =>$user['email'], 'username' => $user['username']];
            $token = \App\Util\Utilities::jwt_encode($data);
            header('Authorization: Bearer '.$token);
            $user['token'] = 'Bearer: ' . $token;

            // Prepare the response data
            unset($user['password']);
            $response = ['status' => 'success', 'user' => $user];

            echo json_encode($response);
        } catch (\PDOException $e) {
            http_response_code(500);
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            header("Content-Type: application/json");
            echo json_encode($response);
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];

            header("Content-Type: application/json");
            echo json_encode($response);
        }
    }


    function delete_logout()
    {
    }


    public function post_forget_password() 
    {
        $email = $_POST['email'];
        $mail = new \PHPMailer\PHPMailer\PHPMailer;
        try {
            //Find email in database
            $sql =  "SELECT * FROM users WHERE  email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->rowCount();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            //check if email provided exist 
            if (!$row > 0) {
                http_response_code(404);
                throw new \Exception("An account with this  email does not exist.");
            }

            //Generate token
            $token = md5(time().rand());
            echo $token . '<br>';

            //Add token to user database
            $sql = 'UPDATE users SET token=:token WHERE email=:email';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->rowCount();
            $new_user = $stmt->fetch(\PDO::FETCH_ASSOC);
            echo 'WHat' . $new_user;
            var_dump($new_user);

            //Send mail
            $mail -> isSMTP();
            $mail -> Host = $_ENV['MAIL_HOST'];
            $mail -> SMTPAuth = true;
            $mail -> Username = $_ENV['MAIL_HOST'];
            $mail -> Password = $_ENV['MAIL_PASSWORD'];
            $mail -> SMTPSecure = $_ENV['MAIL_SEC'];
            $mail -> Port = $_ENV['MAIL_PORT'];

            $mail -> setFrom($_ENV['MAIL_HOST'], $_ENV['MAIL_NAME']);
            $mail -> addAddress('thomashasla4@gmail.com', 'Recipient Name');
            $mail -> isHTML(true);
            $mail -> Subject = 'Forgot Password';
            $mail -> Body = `
            <p>Hello {$user['first_name']}</p>
            <p>We received a request to reset your password. Click the link below to reset it: 
            <a href="{$_ENV['DOMAIN']}/api/v1/reset-password?token={$token}">Reset Password</a></p>
            <p>If you didn\'t request a password reset, you can ignore this email</p>
            <p>Thanks <b>Your Website Team</p>
            `;
            $mail -> send();
            return json_encode([
                'status' => 'success',
                'message' => 'Email has been sent'
            ]);

        } catch (\Throwable $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];

            header("Content-Type: application/json");
            echo json_encode($response);
        }
    }

    function post_reset_password()
    {
    }
}
