<?php
require_once 'auth.php';

if(!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Se non è una richiesta POST, reindirizzo l'utente alla home
    header("Location: home.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
$userid = mysqli_real_escape_string($conn, $userid);

$query1 = "DELETE FROM richieste WHERE id_utente = $userid";
$query2 = "DELETE FROM ordini WHERE id_utente = $userid";
$query3 = "DELETE FROM users WHERE id = $userid";

mysqli_query($conn, $query1);
mysqli_query($conn, $query2);
mysqli_query($conn, $query3);

session_destroy();
header("Location: index.php");
exit;

?>