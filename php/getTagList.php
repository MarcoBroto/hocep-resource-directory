<?php

include('config.php');

$response = [
    'response' => false,
];

if (isset($_GET['type'])) {
    $sql = "SELECT * FROM " . DB_DATABASE . ".{$_GET['type']}";
    $table = $dbconn->query($sql);
    if ($dbconn->connect_error)
        $response['reason'] = $dbconn->connect_error;
    else {
        $rows = [];
        while ($row = $table->fetch_assoc())
            $rows[] = $row;
        $response['tags'] = $rows;
        $response['response'] = true;
        $response['query'] = $sql;
    }
}

echo json_encode($response);
$dbconn->close();