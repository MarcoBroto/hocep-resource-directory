<?php

include('config.php');

$response = ['response' => false];

if (isset($_GET['type'])) {
    $sql = "SELECT * FROM " . DB_DATABASE . ".{$_GET['type']} ORDER BY name";
    $table = $dbconn->query($sql);
    if ($error = $dbconn->connect_error or $dbconn->error)
        $response['error'] = $error;
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
