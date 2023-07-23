<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    include("DbConnect.php");
    include("user/user.php");
    $conn = new DbConnect();
    $userDomain = new User($conn->connect());
    $url_path = explode('/', $_SERVER['REQUEST_URI']);
    $url_matcher = $_SERVER['REQUEST_METHOD'].' '.$url_path[1];

    switch($url_matcher) {
        case 'POST user':
            $userDomain->createUser();
            break;
        case 'GET user':
            $userDomain->getUserDetails($url_path[2]);
            break;
        case 'GET users':
            $userDomain->getUsers();     
            break;
        case 'PUT user':
            $userDomain->updateUser();
            break;
        case 'DELETE user': 
            $userDomain->deleteUser($url_path[2]);
            break;
        default:
            echo $url_matcher;
    }
?>

