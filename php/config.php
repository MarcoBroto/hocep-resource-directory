<?php

//Specify the Database server host
define('DB_SERVER', 'ilinkserver.cs.utep.edu');
//Specify the Database username
define('DB_USERNAME', 'jagomez21');
//Specify the Database password
define('DB_PASSWORD', '*utep2019!');
//Choose the Database (name)
define('DB_DATABASE', 'spr19_team11');

//We make the connection.
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

