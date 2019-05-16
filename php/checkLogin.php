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
        $stmt = $dbconn -> prepare("SELECT * FROM " . DB_DATABASE . ".Admin WHERE username = ?");
        $stmt -> bind_param("s", $username);
        $stmt -> execute();
        $result = $stmt -> get_result();

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (count($row) > 0) {
            if ($password == $row['Password']) {
                $_SESSION['login_user'] = $row['Username'];
                $_SESSION['login_id'] = $row['Admin_id'];
                header("location: ../edit/index.php");
            } else {
                header("location: ../login.php");
            }
        } else {
            header("location: ../login.php");
        }
        $stmt->free_result();
        $stmt->close();
    }