<?php

include('config.php');

$response = [
    'response' => false,
];

$sql = "SELECT * FROM " . DB_DATABASE . ".editor_rows ORDER BY name";
$table = $dbconn->query($sql);
if ($dbconn->connect_error) {
    $response['reason'] = $dbconn->connect_error;
    echo $response;
    $dbconn->close();
    return;
}

$rows = [];
while ($row = $table->fetch_assoc())
    $rows[] = $row;

$response['response'] = true;
$response['resources'] = $rows;
$response['query'] = $sql;
echo json_encode($response);
$dbconn->close();
?>