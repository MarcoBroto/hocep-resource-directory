<?php
include("config.php");

session_start();

if ($dbconn->connect_error) {
    die('Connection Error (' . $dbconn->connect_errno . ') ' . $dbconn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($dbconn, $_POST['username']);
    $password = mysqli_real_escape_string($dbconn, $_POST['password']);

    //Building the query
    $stmt = $dbconn -> prepare("SELECT * FROM " . DB_DATABASE . ".admin WHERE username = ?");
    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $result = $stmt -> get_result();

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (is_null($row)) {
        echo($row);
        http_response_code(400);
        // header('Location: ../login.php');
        // exit;
    } else if (count($row) > 0) {
        if ($password == $row['password']) {
            $_SESSION['login_user'] = $row['username'];
            $_SESSION['login_id'] = $row['admin_id'];
            header("location: ../edit/index.php"); // Go to editor page
        } else { // Wrong Password
            header("location: ../login.php");
        }
    } else { // Invalid Username
        http_response_code(401);
        // header("location: ../login.php");
    }
    $stmt->free_result();
    $stmt->close();
    $dbconn->close();
}
