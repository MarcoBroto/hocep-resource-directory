<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Create tag failed.",
    'type' => $params['type']
];

if (isset($params) && isset($params['type']) && isset($params['tag'])) {
    $tag_type = $params['type'];
    $tag_data = $params['tag'];

    if ($tag_type == 'category') {
        addCategory($tag_data, $dbconn);
    } else {
        addService($tag_data, $dbconn);
    }
}

echo json_encode($response); // Send JSON response
$dbconn->close();


function addCategory($tag_data, mysqli $conn){
    global $response;
    /* Retrieve category tag values and escape strings to prevent SQL injection */
    $tag_name = $conn->real_escape_string($tag_data['name']);
    $tag_description = $conn->real_escape_string($tag_data['description']);
    $sql = "CALL add_category('{$tag_name}', '{$tag_description}');";

    if ($conn->query($sql) && $table = $conn->query("SELECT MAX(category_id) AS 'max_id' FROM " . DB_DATABASE . ".category")) {
        $response['response'] = true;
        $table = mysqli_fetch_array($table);
        $response['new_id'] = $table['max_id'];
        unset($response['message']);
    } 
    else {
        $response['response'] = false;
        $response['message'] = 'Add category tag Failed.';
        echo json_encode($response);
        $conn->close();
        die();
    }

}

function addService($tag_data, mysqli $conn){
    global $response;
    /* Retrieve service tag values and escape strings to prevent SQL injection */
    $tag_name = $conn->real_escape_string($tag_data['name']);
    $tag_description = $conn->real_escape_string($tag_data['description']);
    $sql = "CALL add_service('{$tag_name}', '{$tag_description}');";

    if ($conn->query($sql) && $table = $conn->query("SELECT MAX(service_id) AS 'max_id' FROM " . DB_DATABASE . ".service")) {
        $response['response'] = true;
        $table = mysqli_fetch_array($table);
        $response['new_id'] = $table['max_id'];
        unset($response['message']);
    }
    else {
        $response['response'] = false;
        $response['message'] = 'Add service tag Failed.';
        $response['reason'] = $conn->error;
        echo json_encode($response);
        $conn->close();
        die();
    }
}