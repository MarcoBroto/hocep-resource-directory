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

    //TODO: Construct delete tag query (or call procedure) with the parameters in $params
    //$query = "";
    //$conn = new mysqli($host, $usr, $pass, $dbname);
    //$conn->query($query);


    $response['response'] = true;
    $response['message'] = "Tag was deleted successfully.";
    $response['type'] = $tag_type;
    //$conn->close();
}

echo json_encode($response); // Send JSON response