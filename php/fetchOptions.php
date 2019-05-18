<?php

include('config.php');

$response = [
    'response' => false,
    //'params' => $_GET['options'] // Testing output
];


if ($dbconn->connect_error || !isset($_GET['options'])) {
    $response['error'] = $dbconn->connect_error;
    $dbconn->close();
    echo json_encode($response);
    die();
}

if (isset($_GET['options'])) {
    switch ($_GET['options']) {
        case 'resource':
            $sql = "SELECT * FROM ".DB_DATABASE.".resource_list";
            break;
        case 'category':
            $sql = "SELECT * FROM ".DB_DATABASE.".category_list";
            break;
        case 'service':
            $sql = "SELECT * FROM ".DB_DATABASE.".service_list";
            break;
        case 'zipcode':
            $sql = "SELECT * FROM ".DB_DATABASE.".zipcode_list";
            break;
        default:
            $response['error'] = "Invalid Option";
            echo json_encode($response);
            return;
    }

    $table = $dbconn->query($sql) or $dbconn->error;
    if ($dbconn->error)
        $response['reason'] = $table;
    else {
        $rows = array();
        while ($row = $table->fetch_assoc()) {
            $rows[] = $row;
        }
        $response[$_GET['options']] = $rows;
        $response['response'] = true;
    }
}

echo json_encode($response);
$dbconn->close();
