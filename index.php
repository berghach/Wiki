<?php
session_start();

include("Controller\userController.php");
$userControl = new UserController();

include("Controller/contentController.php");
$contentController = new ContentController();
// $catController->listCategories();

$action = isset( $_GET["action"] ) ? $_GET["action"] :"default";
switch ($action) {
    case 'register':
        $userControl->register();
        break;
    case 'login':
        $userControl->login();
    break;
    case 'logout':
        $userControl->logout();
    break;
    case 'forms':
        include('View\forms.php');
    break;
    default:
        $contentController->getContent();
    break;
}


// session_destroy();

?>