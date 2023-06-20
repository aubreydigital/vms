<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  //Instantiate DB $ connect
  $database = new Database();
  $db = $database->connect();

  //Instantiate blog post object
  $post = new Post($db);

  //get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // set ID to update
  if ($data) {
  $post->post_id = $data->post_id;
  $post->post = $data->post;
  $post->title = $data->title;
  $post->likes = $data->likes;

};
  //update post
  if($post->update()) {
    echo json_encode(
      array('message' => 'post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'post Not Updated')
    );
  }