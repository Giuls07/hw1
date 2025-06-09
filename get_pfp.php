<?php

require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}


// Imposto l'header della risposta
header('Content-Type: application/json');


$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$userid = mysqli_real_escape_string($conn, $userid);
$query = "SELECT pfp FROM users WHERE id = '$userid'";
$res = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($res);

if ($row && !empty($row['pfp'])) { //controlla se la riga esiste e se il campo pfp non è vuoto
    $pfp = $row['pfp'];
} else {
    $pfp = 'pfps/default.jpeg'; // pfp di deafult
}

// Torna un JSON con chiave pfp e valore della pfp
echo json_encode(array('pfp' => $pfp));

mysqli_close($conn);

?>