<?php
include_once('../../config/Database.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$flyer = '';
$artists = '';
$venue = '';
$address = '';
$date = '';
$presale = '';
$presaleCost = '';
$cost = '';
$tickets = '';
$conn = null;

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

$user_name = $data->user_name;
$user_id = $data->user_id;
$title = $data->title;
$post = $data->post;

$table_name = 'post';

$query = "INSERT INTO " . $table_name . "
                SET user_name = :user_name,
                    user_id = :user_id,
                    title = :title,
                    post = :post";

$stmt = $conn->prepare($query);

$stmt->bindParam(':user_name', $user_name);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':post', $post);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "Post created."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "No bueno"));
}
?>
