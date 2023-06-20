<?php
include_once('../../config/Database.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$artist_name = '';
$video_name = '';
$file_name = '';
$conn = null;

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

$artist_name = $data->artist_name;
$video_name = $data->video_name;
$file_name = $data->file_name;

$table_name = 'video';

$query = "INSERT INTO " . $table_name . "
                SET artist_name = :artist_name,
                    video_name = :video_name,
                    file_name = :file_name";

$stmt = $conn->prepare($query);

$stmt->bindParam(':artist_name', $artist_name);
$stmt->bindParam(':video_name', $video_name);
$stmt->bindParam(':file_name', $file_name);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "video created."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "No bueno"));
}
?>
