<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/User.php');
    // require "vendor/autoload.php";
    // use \Firebase\JWT\JWT;
    $database = new Database();
    $db = $database->connect();

    $user = new User($db);
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data)) {
    $user->user_name = $data->user_name;
    $user->user_email = $data->user_email;
    $user->user_password = password_hash($data->user_password, PASSWORD_DEFAULT);

    if($user->create()) {
        echo json_encode(
            array('message' => 'User Created!')
        );
    }
    } else {
        echo json_encode(
            array('message' => 'User not created!')
        );

    }