<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Resource update failed.",
];


if (isset($params) && isset($params['id']) && isset($params['resource'])) {
    $resource_id = $params['id'];
    $resource_data = $params['resource'];

    //TODO: Construct update resource query (or call procedure) with the parameters in $params
    //$query = "";
    //$conn = new mysqli($host, $usr, $pass, $dbname);
    //$conn->query($query);


    $response['response'] = true;
    $response['message'] = "Resource was updated successfully.";
    //$conn->close();
}

$response['params'] = $params;
echo json_encode($response); // Send JSON response