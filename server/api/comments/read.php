<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Comment.php');

$database = new Database();
$db = $database->connect();

$comment = new Comment($db);

$result = $comment->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $comment_array = array();
        $comment_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $comment_item = array(
                'comment_id' => $comment_id,
                'user_name' => $user_name,
                'post_id' => $post_id,
                'comment' => $comment,
                'created_at' => $created_at
            );

            array_push($comment_array['data'], $comment_item);
        }

        echo json_encode($comment_array);
    } else {
        echo json_encode(
            array('message' => 'No comments Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;