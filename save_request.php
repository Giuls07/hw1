<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if(!$_SERVER["REQUEST_METHOD"] === "POST") {
    header("Location: home.php");
    exit;
}

header("Content-Type: application/json");

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
$userid = mysqli_real_escape_string($conn, $userid);
$richiesta = mysqli_real_escape_string($conn, $_POST['richiesta']);
$query = "INSERT INTO richieste (id_utente, richiesta) VALUES ('$userid', '$richiesta')";
if (mysqli_query($conn, $query)) {
    $status = true;
}
else {
    $status = false;
}

echo json_encode(array('status' => $status));
mysqli_close($conn);

?>