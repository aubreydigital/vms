<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Track.php');

$database = new Database();
$db = $database->connect();

$track = new Track($db);

$result = $track->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $track_array = array();
        $track_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $track_item = array(
                'track_id' => $track_id,
                'artist_name' => $artist_name,
                'track_name' => $track_name,
                'file_name' => $file_name,
                'image' => $image,
                'created_at' => $created_at
            );

            array_push($track_array['data'], $track_item);
        }

        echo json_encode($track_array);
    } else {
        echo json_encode(
            array('message' => 'No tracks Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;