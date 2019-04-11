<?php
/**
 * Created by PhpStorm.
 * User: msoto
 * Date: 2019-03-17
 * Time: 23:25
 */

//echo "<h1>Getting Login</h1>";
$uname = $_POST['username'];
$pass = $_POST['password'];

$conn = mysqli_connect('localhost:3306', 'dbuser', 'password', 'dbname');
$query = "SELECT * FROM Admin WHERE username='{$uname}'";
$admin = $conn->query($query) or die("Query Error");


if ($admin = $admin->fetch_assoc()) {
    if ($admin['password'] == $pass) {
        header("Location: /edit.php?uname={$uname}");
        exit();
    }
    else { // Invalid Password
        echo 'Invalid password'
        header('Location: /login.php');
        exit();
    }
}
else { // Invalid Username
    echo json_encode($admin);
    echo 'Invalid username';
    die();
}
