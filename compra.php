<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: home.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$userid = mysqli_real_escape_string($conn, $userid);
$cover = mysqli_real_escape_string($conn, $_POST['immagine']);
$artista = mysqli_real_escape_string($conn, $_POST['artista']);
$data = mysqli_real_escape_string($conn, $_POST['data']);
$ora = mysqli_real_escape_string($conn, $_POST['ora']);
$prezzo = mysqli_real_escape_string($conn, $_POST['prezzo']);

$query = "INSERT INTO ordini (id_utente, cover, artista, data_evento, ora_evento, prezzo) VALUES ('$userid', '$cover', '$artista', '$data', '$ora', '$prezzo')";

mysqli_query($conn, $query);
mysqli_close($conn);

header("Location: home.php");
exit;
?>