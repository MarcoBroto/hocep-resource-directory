<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 3/12/19
 * Time: 8:22 PM
 */

include('config.php');

$response = [
    'response' => false,
//    'params' => $_GET, // Test output
];

$sql = "SELECT * FROM " . DB_DATABASE . ".search_rows"; // Original query, contains all rows

if (isset($_GET['resource'])) { // Resource is selected, only search for resources
    $sql = $sql . " WHERE id IN (" . $_GET['resource'] . ");";
}
else { // Resource is not selected, search by criteria [NOTE: Uses the intersection of category and service sets]
    $sql_append = "";

    // Append insurance query
    if (!$_GET['insurance'] = ($_GET['insurance'] == 'true') ? 0 : 1)
        $sql_append = $sql_append . " WHERE search_rows.insurance={$_GET['insurance']}";

    // Append category query
    if (isset($_GET['category'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND search_rows.id IN (";
        else $sql_append = $sql_append . " WHERE search_rows.id IN (";
        $categories = explode(",", $_GET['category']);
        $count = count($categories);
        foreach ($categories as $category) {
            if (--$count <= 0) break;
            $sql_append = $sql_append . "SELECT resource_id FROM " . DB_DATABASE . ".belongs_to WHERE category_id=1 AND resource_id IN (";
        }
        $sql_append = $sql_append . "SELECT resource_id FROM " . DB_DATABASE . ".belongs_to WHERE category_id=" . $categories[count($categories)-1];
        for ($i = 0; $i < count($categories); $i++)
            $sql_append = $sql_append . ")";
    }

    // Append service query
    if (isset($_GET['service'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND search_rows.id IN (";
        else $sql_append = $sql_append . " WHERE search_rows.id IN (";
        $services = explode(",", $_GET['service']);
        $count = count($services);
        foreach ($services as $service) {
            if (--$count <= 0) break;
            $sql_append = $sql_append . "SELECT resource_id FROM " . DB_DATABASE . ".provides WHERE service_id=".$service." AND resource_id IN (";
        }
        $sql_append = $sql_append . "SELECT resource_id FROM " . DB_DATABASE . ".provides WHERE service_id=" . $services[count($services)-1];
        for ($i = 0; $i < count($services); $i++)
            $sql_append = $sql_append . ")";
    }

    // Append zipcode query
    if (isset($_GET['zipcode'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND search_rows.id IN (" . $_GET['zipcode'] . ")";
        else $sql_append = $sql_append . " WHERE search_rows.zipcode IN (" . $_GET['zipcode'] . ")";
    }

    $sql = $sql . $sql_append; // Append to actual query
}


// Testing block
//$response['query'] = $sql;
//sleep(2); // Used to simulate 'long query' testing

// Fetch query results
$table = $dbconn->query($sql) or $dbconn->error;
if ($dbconn->error) {
    $response['reason'] = $dbconn->error;
}
else {
    $rows = array();
    while ( $row = $table->fetch_assoc() )  {
        $rows[] = $row;
    }
    $response['resources'] = $rows;
    $response['response'] = true;
}

echo json_encode($response);
$dbconn->close();
