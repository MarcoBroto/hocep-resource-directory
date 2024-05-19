<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Delete resource failed.",
//    'params' => $params, // Testing output
];

if (isset($params) && isset($params['id'])) {
    $resource_id = $params['id'];

    if ($dbconn->error) {
        $dbconn->close();
        die("Connection failed: " . mysqli_connect_error());
    }
    else {
       deleteResource($resource_id, $dbconn);
    }
}

echo json_encode($response); // Send JSON response
$dbconn->close();



function deleteResource($resource_id, mysqli $conn){
    global $response;
    $sql = "CALL delete_resource($resource_id);";

    if ($conn->query($sql)) {
        $response['response'] = true;
        $response['message'] = "Deleted resource successfully.";
    } 
    else {
        $response['error'] = $conn->error;
        $response['message'] = "Delete resource failed.";
    }

}
