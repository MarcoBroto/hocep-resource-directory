<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Update tag failed.",
    'type' => $params['type'],
];

if (isset($params) && isset($params['type']) && isset($params['id']) && isset($params['tag'])) {
    $tag_type = $params['type'];
    $tag_id = $params['id'];
    $tag_data = $params['tag'];

    if (mysqli_connect_errno()) {
        $response['message'] = mysqli_connect_error();
        echo json_encode($response);
        $dbconn->close();
        die("Connection failed: " . mysqli_connect_error());
    } 
    else{
        if ($tag_type == 'category'){
            updateCategory($tag_id, $tag_data, $dbconn);
        }
        else{
            updateService($tag_id, $tag_data, $dbconn);
        }

    }
}

echo json_encode($response); // Send JSON response
$dbconn->close();



function updateCategory($tag_id, $tag_data, $conn){
    global $response;
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $sql = "CALL updateCategory($tag_id, '$tag_name', '$tag_description');";

    if (mysqli_query($conn, $sql)) {
        $response['response'] = true;
        $response['message'] = "Update tag passed.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function updateService($tag_id, $tag_data, $conn){
    global $response;
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $sql = "CALL updateService($tag_id, '$tag_name', '$tag_description');";

    if (mysqli_query($conn, $sql)) {
        $response['response'] = true;
        $response['message'] = "Update tag passed.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>