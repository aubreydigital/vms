<?php
include_once('../../config/Database.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$user_name = '';
$post_id = '';
$comment = '';
$conn = null;

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

$user_name = $data->user_name;
$post_id = $data->post_id;
$comment = $data->comment;

$table_name = 'comments';

$query = "INSERT INTO " . $table_name . "
                SET user_name = :user_name,
                    post_id = :post_id,
                    comment = :comment";

$stmt = $conn->prepare($query);

$stmt->bindParam(':user_name', $user_name);
$stmt->bindParam(':post_id', $post_id);
$stmt->bindParam(':comment', $comment);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "Comment created."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "No bueno"));
}
?>
