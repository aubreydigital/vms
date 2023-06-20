<?php
include_once '../../config/database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_email = '';
$user_password = '';

$db = new Database();
$conn = $db->connect();



$data = json_decode(file_get_contents("php://input"));

$user_email = $data->user_email;
$user_password = $data->user_password;

$table_name = 'User';

$query = "SELECT user_id, user_name, user_password FROM " . $table_name . " WHERE user_email = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $user_email);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $password2 = $row['user_password'];

    if(password_verify($user_password, $password2))
    {
        $secret_key = "YOUR_SECRET_KEY";
        // $issuer_claim = "localhost:8888"; // this can be the servername
        $issuer_claim = "https://aubrey.digital"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "user_id" => $user_id,
                "user_name" => $user_name,
                "user_email" => $user_email
        ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "user_id" => $user_id,
                "jwt" => $jwt,
                "user_email" => $user_email,
                "expireAt" => $expire_claim
            ));
            
    }
    else{
        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "user_password" => $user_password));
    }
}

print_r($_SESSION);
?>