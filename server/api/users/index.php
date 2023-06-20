<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/User.php');

$database = new Database();
$db = $database->connect();

$user = new User($db);

$result = $user->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $user_array = array();
        $user_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                'user_id' => $user_id,
                'user_name' => $user_name,
                'profile_pic' => $profile_pic,
                'full_name' => $full_name,
                'pronouns' => $pronouns,
                'artist_name' => $artist_name,
                'user_email' => $user_email,
                'phone_number' => $phone_number,
                'user_password' => $user_password,
                'website' => $website,
                'twitter' => $twitter,
                'twitch' => $twitch,
                'soundcloud' => $soundcloud,
                'instagram' => $instagram,
                'created_at' => $created_at
            );

            array_push($user_array['data'], $user_item);
        }

        echo json_encode($user_array);
    } else {
        echo json_encode(
            array('message' => 'No Users Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;