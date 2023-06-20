<?php
include_once('../../config/Database.php');

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$artist_name = '';
$track_name = '';
$file_name = '';
$image = '';
$conn = null;

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

$artist_name = $data->artist_name;
$track_name = $data->track_name;
$file_name = $data->file_name;
$image = $data->image;

$table_name = 'tracks';

$query = "INSERT INTO " . $table_name . "
                SET artist_name = :artist_name,
                    track_name = :track_name,
                    file_name = :file_name,
                    image = :image";

$stmt = $conn->prepare($query);

$stmt->bindParam(':artist_name', $artist_name);
$stmt->bindParam(':track_name', $track_name);
$stmt->bindParam(':file_name', $file_name);
$stmt->bindParam(':image', $image);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "Track created."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "No bueno"));
}
?>
