<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Delete resource failed."
];

if (isset($params) && isset($params['id'])) {
    $resource_id = $params['id'];

    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 
    else {
       deleteResource($resource_id, $dbconn);
    }
    mysqli_close($dbconn);
}

function deleteResource($resource_id, $conn){
    global $response;
    $sql = "CALL deleteResource($resource_id);";

    if (mysqli_query($conn, $sql)) {
        $response['response'] = true;
        $response['message'] = "Delete resource passed.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

echo json_encode($response); // Send JSON response
?>