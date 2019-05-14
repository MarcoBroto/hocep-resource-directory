<?php
//How to use: Include this file in desire .php -> include("config.php");
//You then will be able to use "$db".

error_reporting(E_ERROR);

//Specify the Database server host
define('DB_SERVER', 'ilinkserver.cs.utep.edu');
//Specify the Database username
define('DB_USERNAME', 'jagomez21');
//Specify the Database password
define('DB_PASSWORD', '*utep2019!');
//Choose the Database (name)
define('DB_DATABASE', 'spr19_team11');
//We make the connection.
$dbconn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);