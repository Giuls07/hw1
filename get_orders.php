<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$userid = mysqli_real_escape_string($conn, $userid);

$query = "SELECT * FROM ordini WHERE id_utente = '$userid'";
$res = mysqli_query($conn, $query);
$orders = array();
while ($row = mysqli_fetch_assoc($res)) {
    $orders[] = array(
        'id' => $row['id_ordine'],
        'cover' => $row['cover'],
        'artista' => $row['artista'],
        'data' => $row['data_evento'],
        'ora' => $row['ora_evento']
    );
}

// Torna un JSON con chiave orders e valore degli ordini
echo json_encode(array('orders' => $orders));

mysqli_close($conn);
?>