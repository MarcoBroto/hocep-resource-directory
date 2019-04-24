<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 3/12/19
 * Time: 8:22 PM
 */


    $query = "SELECT * FROM resource;"; // Dummy query, build off of this
    //$query = constructFilteredQuery();
    getConnection();
    $resourceList = sendQuery($query);
//    sleep(0); // Use for 'long query' testing
    echo $resourceList;


    function getConnection() {
        $host = "localhost:3306";
        $user = "dbuser";
        $pass = "password";
        $dbname = "dbname";

        // Create connection
        error_reporting(E_ERROR); // Use to remove error echoing
        $GLOBALS['link'] = new mysqli($host, $user, $pass, $dbname);

        $response = false;

        if ($GLOBALS['link']->connect_error) {
            echo json_encode(['response' => $response]);
            die();
            //die("Connection failed: " . $GLOBALS['link']->connect_error);
        }
    }

    function constructFilteredQuery() {
        $params = [
            'keyword' => $_GET['keywords'],
            'service' => $_GET['service'],
            'zipcode' => $_GET['zipcode'],
        ];

        $query = "SELECT * FROM resource";

        return $query;
    }

    function sendQuery($query) {
        $conn = $GLOBALS['link'];

        if ($conn->connect_error) {
            die("Connection failed: " . $GLOBALS['link']->connect_error);
        }

        $table = $conn->query($query) or die($conn->error);

        //
        $rows = array();
        while ( $row = $table->fetch_assoc() )  {
            $rows[] = $row;
        }

        $jsonResponse = json_encode($rows);
        $GLOBALS['response'] = $jsonResponse;
        return $jsonResponse;
    }
