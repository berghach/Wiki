<?php
session_start();

include("Controller\userController.php");

$userControl = new UserController();

// if($_SERVER["REQUEST_METHOD"] == "GET"){
    $action = isset( $_GET["action"] ) ? $_GET["action"] :"default";
    switch ($action) {
        case 'login':
            $userControl->login();
        break;
        case 'register':
            $userControl->register();
        break;
        default:
            include("View\home.php");
        break;
    }
// }


// session_destroy();

?>