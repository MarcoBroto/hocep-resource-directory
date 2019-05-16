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

    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 
    else {
        if ($tag_type == 'category'){
            addCategory($tag_data, $dbconn);
        }
        else{
            addService($tag_data, $dbconn);
        }

    }
    mysqli_close($dbconn);
}

function addCategory($tag_data, $conn){
    global $response;
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $sql = "CALL addCategory('$tag_name', '$tag_description');";

    if (mysqli_query($conn, $sql) && $table = $conn->query("SELECT MAX(category_id) AS 'max_id' FROM " . DB_DATABASE . ".category")) {
        $response['response'] = true;
        $table = mysqli_fetch_array($table);
        $response['new_id'] = $table['max_id'];
        unset($response['message']);
    } 
    else {
        $response['response'] = false;
        $response['message'] = 'Add category tag Failed.';
    }

}

function addService($tag_data, $conn){
    global $response;
    $tag_name = $tag_data['name'];
    $tag_description = $tag_data['description'];
    $sql = "CALL addService('$tag_name', '$tag_description');";

    if (mysqli_query($conn, $sql) && $table = $conn->query("SELECT MAX(service_id) AS 'max_id' FROM " . DB_DATABASE . ".service")) {
        $response['response'] = true;
        $table = mysqli_fetch_array($table);
        $response['new_id'] = $table['max_id'];
        unset($response['message']);
    } 
    else {
        $response['response'] = false;
        $response['message'] = 'Add service tag failed';
    }
}

echo json_encode($response); // Send JSON response

?>