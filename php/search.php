<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 3/12/19
 * Time: 8:22 PM
 */

$response = ['response' => false];

$host = "ilinkserver.cs.utep";
$user = "mrsoto3";
$pass = "*utep2019!";
$dbname = "spr19_team11";

//error_reporting(E_ERROR); // Use to remove error echoing
//$conn = new mysqli($host, $user, $pass, $dbname) or die("Connection failed: " . $GLOBALS['link']->connect_error);


function sendQuery($dbconn, $query) {

    if ($dbconn->connect_error) {
        die("Connection failed: " . $GLOBALS['link']->connect_error);
    }

    $table = $dbconn->query($query) or die($dbconn->error);
    $rows = array();
    while ( $row = $table->fetch_assoc() )  {
        $rows[] = $row;
    }

    $jsonResponse = json_encode($rows);
    return $jsonResponse;
}

$response['params'] = $_GET;
$response['test'] = isset($_GET['service']);

// sleep(0); // Used to simulate 'long query' testing
echo json_encode($response);
//$conn->close();
