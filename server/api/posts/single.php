<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  //Instantiate DB $ connect
  $database = new Database();
  $db = $database->connect();

  //Instantiate blog post object
  $post = new Post($db);

  //get id fropm url
  $post->post_id = isset($_GET['post_id']) ? $_GET['post_id'] : die();

  //get post
  $post->read_single();

  //Create array
  $post_arr = array(
    'post_id' => $post->post_id,
    'user_id' => $post->user_id,
    'user_name' => $post->user_name,
    'post' => $post->post,
    'title' => $post->title,
    'likes' => $post->likes,
    'created_at' => $post->created_at
  );

  //make json
  print_r(json_encode($post_arr));