<?php
    include("config.php");
    session_start();

    // Verifying if the login_user session variable is empty
    if(!empty($_SESSION['login_user'])) {

        $user_check = $_SESSION['login_user'];
        $ses_sql = mysqli_query($dbconn,"SELECT * FROM " . DB_DATABASE . ".Admin WHERE 'username' = {$user_check}");

        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

        //We assign the result to the $login_session variable
        $login_session = $row['Username'];

        if(!isset($_SESSION['login_user'])){
            header("location: ../edit/index.php");
        }
    } else {
        header("location:../login.php");
    }