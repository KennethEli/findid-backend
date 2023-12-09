<?php

$errorcode = 0;

class AuthController {
    private $conn;
    
    function __construct($conn)
    {
        $this->conn = $conn;
    }

/**
 * params()
 * retun()
 * Registration Function
 */
 function post_register ()  {
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
        if($_POST['password'] !== $_POST['confirm_password']) {
            http_response_code(401);
            throw new Exception('Passwords do not matct');
        }

        // Check if username already exists
        $sql = "SELECT * FROM users WHERE email = :email AND username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            http_response_code(403);
            throw new Exception("user account or email already exists.");
        }


        // Create user account
        $sql = "INSERT INTO users (first_name, last_name, other_name, username, email, password, dob, gender, phone_number, location, occupation, momo_number, institution_name)
        VALUES (:first_name, :last_name, :other_name, :username, :email, :password, :dob, :gender, :phone_number, :location, :occupation, :momo_number, :institution_name)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':other_name', $other_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':occupation', $occupation, PDO::PARAM_STR);
        $stmt->bindParam(':momo_number', $momo_number, PDO::PARAM_STR);
        $stmt->bindParam(':institution_name', $institution_name, PDO::PARAM_STR);
        $stmt->execute();

        header("Content-Type: application/json");

        $response = ['status' => 'success', 'message' => 'Account created successfully'];
        echo json_encode($response);
    }
    catch (PDOException $e){
        http_response_code(500);
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
        header("Content-Type: application/json");
        echo json_encode($response);
        
    } catch (Exception $e){
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
    }
       

 }


 /**
  * 
  *
  *
  */
  function get_login () {

  }


  function delete_logout () {

  }


  function get_forget_password () {

  }

  function post_reset_password () {

  }

}