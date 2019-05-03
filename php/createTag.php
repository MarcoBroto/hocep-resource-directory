<?php

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$host = 'cssrvlab01.utep.edu:21';
$usr = 'mrsoto3';
$pass = '*utep2019!';
$dbname = 'spr19_team11';

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Create tag failed.",
    'type' => $params['type']
];


if (isset($params) && isset($params['type']) && isset($params['tag'])) {
    $tag_type = $params['type'];
    $tag_data = $params['tag'];

    //TODO: Construct create tag query (or call procedure) with the parameters in $params
    //$query = "";
    //$conn = new mysqli($host, $usr, $pass, $dbname);
    //$conn->query($query);


    $response['response'] = true;
    $response['message'] = "Tag was created successfully.";
    $response['type'] = $tag_type;
    //$conn->close();
}

echo json_encode($response); // Send JSON response