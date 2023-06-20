<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Video.php');

$database = new Database();
$db = $database->connect();

$video = new Video($db);

$result = $video->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $video_array = array();
        $video_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $video_item = array(
                'video_id' => $video_id,
                'artist_name' => $artist_name,
                'video_name' => $video_name,
                'file_name' => $file_name,
                'created_at' => $created_at
            );

            array_push($video_array['data'], $video_item);
        }

        echo json_encode($video_array);
    } else {
        echo json_encode(
            array('message' => 'No videos Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;