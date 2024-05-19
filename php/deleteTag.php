<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Delete tag failed.",
    'type' => $params['type'],
//    'params' => $params, // Testing output
];


if (isset($params) && isset($params['type']) && isset($params['id'])) {
    $tag_type = $params['type'];
    $tag_id = $params['id'];

    if ($dbconn->error) $response['error'] = mysqli_connect_errno() . mysqli_connect_error();
    else {
        if ($tag_type == 'category')
            deleteCategory($tag_id, $dbconn);
        else
            deleteService($tag_id, $dbconn);
    }
}

echo json_encode($response); // Send JSON response
$dbconn->close();


function deleteCategory($tag_id, mysqli $conn){
    global $response;
    $sql = "CALL delete_category($tag_id);";
    if ($conn->query($sql)) $response['response'] = true;
    else $response['error'] = $conn->error;

}

function deleteService($tag_id, mysqli $conn){
    global $response;
    $sql = "CALL delete_service($tag_id);";
    if ($conn->query($sql)) $response['response'] = true;
    else $response['error'] = $conn->error;
}
