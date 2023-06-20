<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $post_array = array();
        $post_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'post_id' => $post_id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'post' => $post,
                'title' => $title,
                'likes' => $likes,
                'created_at' => $created_at
            );

            array_push($post_array['data'], $post_item);
        }

        echo json_encode($post_array);
    } else {
        echo json_encode(
            array('message' => 'No posts Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;