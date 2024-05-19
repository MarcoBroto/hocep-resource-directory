<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Update tag failed.",
//    'params'] = $params, // Testing output
];

if (isset($params) && isset($params['type']) && isset($params['tag'])) {
    $tag_type = $params['type'];
    $tag_data = $params['tag'];
    $params['type'] = $tag_type;

    if (mysqli_connect_errno()) {
        $response['message'] = mysqli_connect_errno() . mysqli_connect_error();
        echo json_encode($response);
        $dbconn->close();
        die("Connection failed: " . mysqli_connect_error());
    } 
    else {
        if ($tag_type == 'category')
            updateCategory($tag_data, $dbconn);
        else
            updateService($tag_data, $dbconn);
    }
}

echo json_encode($response); // Send JSON response
$dbconn->close();



function updateCategory($tag_data, mysqli $conn){
    global $response;
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $tag_id = $tag_data['id'];
    $sql = "CALL update_category($tag_id, '$tag_name', '$tag_description');";

    if ($conn->query($sql)) $response['response'] = true;
    else {
        $response['error'] = $conn->error;
        $response['message'] = "Update Category Failed";
        echo json_encode($response);
        $conn->close();
        die();
    }
}

function updateService($tag_data, mysqli $conn){
    global $response;
    $tag_id = $tag_data['id'];
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $sql = "CALL update_service($tag_id, '$tag_name', '$tag_description');";

    if ($conn->query($sql)) $response['response'] = true;
    else {
        $response['error'] = $conn->error;
        $response['message'] = "Update Service Failed";
        echo json_encode($response);
        $conn->close();
        die();
    }
}
