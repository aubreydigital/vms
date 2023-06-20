<?php
include_once('../../config/Database.php');
include_once('../../models/User.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$user_name = '';
$user_email = '';
$user_password = '';
$conn = null;

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

$user_name = $data->user_name;
$user_email = $data->user_email;
$user_password = $data->user_password;

$table_name = 'user';

$query = "INSERT INTO " . $table_name . "
                SET user_name = :user_name,
                    user_email = :user_email,
                    user_password = :user_password";

$stmt = $conn->prepare($query);

$stmt->bindParam(':user_name', $user_name);
$stmt->bindParam(':user_email', $user_email);

$password_hash = password_hash($user_password, PASSWORD_BCRYPT);

$stmt->bindParam(':user_password', $password_hash);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
?>
