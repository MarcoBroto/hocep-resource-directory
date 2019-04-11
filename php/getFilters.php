<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 3/17/19
 * Time: 1:03 PM
 */

/*  */
$conn = getConnection();
echo (getAvailableFilterOptions($conn));

/*  */
function getConnection() {
    $dbhost = "localhost:3306";
    $port = "3306";
    $dbuser = "dbuser";
    $dbpass = "password";
    $dbname = "dbname";

    // Create connection
    $conn = new mysqli($host=$dbhost, $username=$dbuser, $passwd=$dbpass, $dbname=$dbname);
    //$conn = new mysqli($dbhost, $dbuser, $dbpass);
    $response = false;

    if ($GLOBALS['link']->connect_error) {
        echo json_encode(['response' => $response]);
        die();
        //die("Connection failed: " . $GLOBALS['link']->connect_error);
    }
    return $conn;
}

/*  */
function getAvailableFilterOptions(mysqli $dbConn) {
    $queries = [
        'query_name' => "SELECT org_name FROM Resource LIMIT 20",
        'query_keyword' => "SELECT name FROM Keyword LIMIT 20",
        'query_service' => "SELECT name FROM Service LIMIT 20",
        'query_zipcodes' => "SELECT DISTINCT zipcode FROM Resource",
    ];

    $results = array();
    foreach ($queries as $query) {
        $results[$query] = $dbConn->query($queries[$query]);
    }

    return $results;
}
