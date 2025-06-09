<?php
require_once 'auth.php';

if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(empty($_POST["new_pfp"])) {
        header("Location: profile.php");
        exit;
    }
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT * FROM users WHERE id = '$userid'";

    $res = mysqli_query($conn, $query);

    $pfp = $_POST["new_pfp"];

    $pfp = mysqli_real_escape_string($conn, $pfp);

    $query1 = "UPDATE users SET pfp = '$pfp' WHERE id = '$userid'";
    $res1 = mysqli_query($conn, $query1);

    mysqli_close($conn);

    header("Location: profile.php");
    exit;
}
else{
    header("Location: profile.php");
    exit;
}
?>