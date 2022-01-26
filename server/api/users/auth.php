<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/User.php');

$database = new Database();
$db = $database->connect();

$token = new User($db);



if ($token->auth()) {
    http_response_code(200);
    echo json_encode(
        $token->auth()
    );
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'Could not create token. Please contact the administrator.')
    );
}