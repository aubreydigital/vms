<?php

ini_set("display_errors",1);
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/User.php');

$database = new Database();
$db = $database->connect();

$user = new User($db);

$user->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

$user->read_single();

$user_array = array(
    'user_id' => $user->user_id,
    'user_name' => $user->user_name,
    'user_email' => $user->user_email,
    'full_name' => $user->full_name,
    'artist_name' => $user->artist_name,
    'website' => $user->website,
    'twitter' => $user->twitter,
    'twitch' => $user->twitch,
    'soundcloud' => $user->soundcloud,
    'instagram' => $user->instagram,
    'phone_number' => $user->phone_number,
);

echo json_encode($user_array);

// print_r(json_encode($user_array));