<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 3/12/19
 * Time: 8:22 PM
 */

include('config.php');

$response = ['response' => false];

$sql = "SELECT * FROM search_rows"; // Original query, contains all rows

if (isset($_GET['resource'])) { // Resource is selected, only search for resources
    $sql = $sql . " WHERE resource_id IN (" . $_GET['resource'] . ");";
}
else { // Resource is not selected, search by criteria [NOTE: Uses the intersection of category and service sets]
    $sql_append = null;
    // Append insurance query
    if ($_GET['insurance'] === 'true' ? true : false)
        $sql_append = $sql_append . " WHERE insurance='" . $_GET['insurance'] . "'";
    // Append category query
    if (isset($_GET['category'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND resource_id IN (";
        else $sql_append = $sql_append . " WHERE resource_id IN (";
        $categories = explode(",", $_GET['category']);
        $count = count($categories);
        foreach ($categories as $category) {
            if (--$count <= 0) break;
            $sql_append = $sql_append . "SELECT resource_id FROM belongs_to WHERE category_id=1 AND resource_id IN (";
        }
        $sql_append = $sql_append . "SELECT resource_id FROM belongs_to WHERE category_id=" . $categories[count($categories)-1];
        for ($i = 0; $i < count($categories); $i++)
            $sql_append = $sql_append . ")";
    }
    // Append service query
    if (isset($_GET['service'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND resource_id IN (";
        else $sql_append = $sql_append . " WHERE resource_id IN (";
        $services = explode(",", $_GET['service']);
        $count = count($services);
        foreach ($services as $service) {
            if (--$count <= 0) break;
            $sql_append = $sql_append . "SELECT resource_id FROM provides WHERE service_id=".$service." AND resource_id IN (";
        }
        $sql_append = $sql_append . "SELECT resource_id FROM provides WHERE service_id=" . $services[count($services)-1];
        for ($i = 0; $i < count($services); $i++)
            $sql_append = $sql_append . ")";
    }
    // Append zipcode query
    if (isset($_GET['zipcode'])) {
        if (isset($sql_append)) $sql_append = $sql_append . " AND resource_id IN (" . $_GET['zipcode'] . ")";
        else $sql_append = $sql_append . " WHERE zipcode IN (" . $_GET['zipcode'] . ")";
    }
    $sql = $sql . $sql_append;
}

$response['params'] = $_GET;
$response['query'] = $sql;

sleep(2); // Used to simulate 'long query' testing]
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
//$dbconn->close();