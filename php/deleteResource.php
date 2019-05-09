<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Delete resource failed."
];


if (isset($params) && isset($params['id'])) {
    $resource_id = $params['id'];

    //TODO: Construct delete resource query (or call procedure) with the id parameter in $params
    //$query = "";
    //$conn = new mysqli($host, $usr, $pass, $dbname);
    //$conn->query($query);


    $response['response'] = true;
    $response['message'] = "Resource was deleted successfully.";
    //$conn->close();
}

$response['params'] = $params;
echo json_encode($response); // Send JSON response