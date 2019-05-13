<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Delete tag failed.",
    'type' => $params['type']
];


if (isset($params) && isset($params['type']) && isset($params['id'])) {
    $tag_type = $params['type'];
    $tag_id = $params['id'];

    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 
    else {
        if ($tag_type == 'category'){
            deleteCategory($tag_id, $db);
        }
        else{
            deleteService($tag_id, $db);
        }

    }
    mysqli_close($db);
}

function deleteCategory($tag_id, $conn){
    global $response;
    $sql = "CALL deleteCategory($tag_id);";

    if (mysqli_query($conn, $sql)) {
        $response['response'] = true;
        $response['message'] = "Delete tag passed.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

function deleteService($tag_id, $conn){
    global $response;
    $sql = "CALL deleteService($tag_id);";

    if (mysqli_query($conn, $sql)) {
        $response['response'] = true;
        $response['message'] = "Delete tag passed.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

echo json_encode($response); // Send JSON response
?>