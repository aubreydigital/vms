<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Show.php');

$database = new Database();
$db = $database->connect();

$show = new Show($db);

$result = $show->read();
if($result):
    $num = $result->rowCount();

    if ($num > 0) {
        $show_array = array();
        $show_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $show_item = array(
                'show_id' => $show_id,
                'flyer' => $flyer,
                'artists' => $artists,
                'venue' => $venue,
                'address' => $address,
                'date' => $date,
                'over21' => $over21,
                'cost' => $cost,
                'presaleCost' => $presaleCost,
                'created_at' => $created_at,
                'tickets' => $tickets
                
            );

            array_push($show_array['data'], $show_item);
        }

        echo json_encode($show_array);
    } else {
        echo json_encode(
            array('message' => 'No shows Found')
        );
}

    else:
        echo json_encode(
            array('message' => 'Your token didn\'t match')
        );
    endif;