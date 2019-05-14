<?php
    include("config.php");

    session_start();

    if ($db->connect_error) {
        die('Connection Error (' . $db->connect_errno . ') ' . $db->connect_error);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        //Building the query
        $stmt = $db -> prepare("SELECT * FROM Admin WHERE Username = ?");
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
                $error = "Invalid password.";
                header("location: ../login.php");
            }
        } else {
            $error = "Invalid username or password.";
            header("location: ../login.php");
        }
        $stmt->free_result();
        $stmt->close();
    }