<?php
//How to use: Include this file in desire .php -> include("config.php");
//You then will be able to use "$dbconn".

error_reporting(E_ERROR);

//Specify the Database server host
define('DB_SERVER', 'mysql:3306');
//Specify the Database username
define('DB_USERNAME', 'tester');
//Specify the Database password
define('DB_PASSWORD', 'Mysqllocalhost123!');
//Choose the Database (name)
define('DB_DATABASE', 'oc_db');
//We make the connection.
$dbconn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$dbconn) {
    echo json_encode(['response' => false, 'reason' => "Could not connect to database"]);
    die();
}
