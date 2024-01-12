<?php

require_once("Model\userModel.php");

class UserController{
    function login(){
        // session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $userDAO = new userDAO();
            $user = $userDAO->getUser_by_username($username);

            $userSESSION = array();
            if(!empty($user)){
                if($user->getUserrole() == 'admin'){
                    if($user->getPassword() == $password){
                        $userSESSION['username'] = $user->getUsername();
                        $userSESSION['role'] = $user->getUserrole();
                        $_SESSION['User_session'] = $userSESSION;

                        header("Location: index.php?action=default");
                        exit();
                    }else{
                        $_SESSION['login_error'] = 'Error: password incorrect';
                        header("Location: index.php?action=login");
                        exit();
                    }
                }else{
                    if(password_verify($password, $user->getPassword())){
                        $userSESSION['username'] = $user->getUsername();
                        $userSESSION['role'] = $user->getUserrole();
                        $_SESSION['User_session'] = $userSESSION;

                        header("Location: index.php?action=default");
                        exit();
                    }else{
                        $_SESSION['login_error'] = 'Error: password incorrect';
                        header("Location: index.php?action=login");
                        exit();
                    }
                }
            }else{
                $_SESSION['login_error'] = 'Error: User not found';
                header("Location: index.php?action=login");
                exit();
            }   
        }
        include("View\login.php");
        unset($_SESSION['login_error']);
    }
    function register(){
        // session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $fullname = $_POST["fullname"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirm_pass = $_POST["confirmPassword"];

            function isValidEmail($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            }

            // Validation errors array
            $errors = [];

            // Validation

            if (empty($fullname)) {
                $errors['fullname'] = "Error: Full Name is required.";
            }

            if (empty($username)) {
                $errors['username'] = "Error: User Name is required.";
            }

            if (!isValidEmail($email)) {
                $errors['email'] = "Error: Invalid email address.";
            }
            if (empty($password)) {
                $errors["password"] = "Error: Password is required.";
            }
            
            if ($password !== $confirm_pass) {
                $errors['confirm_pass'] = "Error: Passwords do not match.";
            }
            // If there are errors, store them in the session variable
            if (!empty($errors)) {
                $_SESSION['register_errors'] = $errors;
                header("Location: index.php?action=register");
                exit();
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $user = new User(0, $fullname, $username, $email, $hashed_password, 0);

            $adduser = new userDAO();
            $adduser->addUser($user);
        }
        include("View/register.php");
        unset($_SESSION['register_errors']);
    }
}

?>