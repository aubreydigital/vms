<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  //Instantiate DB $ connect
  $database = new Database();
  $db = $database->connect();

  //Instantiate blog post object
  $user = new User($db);

  //get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // set ID to update
  if ($data) {
  $user->user_id = $data->user_id;

  $user->user_name = $data->user_name;
  $user->user_email = $data->user_email;
  $user->user_password = $data->user_password;
  $user->full_name = $data->full_name;
  $user->artist_name = $data->artist_name;
  $user->phone_number = $data->phone_number;
  $user->website = $data->website;
  $user->twitter = $data->twitter;
  $user->twitch = $data->twitch;
  $user->soundcloud = $data->soundcloud;
  $user->instagram = $data->instagram;

};
  //update post
  if($user->update()) {
    echo json_encode(
      array('message' => 'User Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Updated')
    );
  }