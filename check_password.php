<?php
    /*******************************************************
        Controlla che la password sia nuova
    ********************************************************/
    require_once 'auth.php';

    if(!$userid = checkAuth()) {
        header('Location: login.php');
        exit;
    }
    
    //se non abbiamo ricevuto una richiesta GET con il parametro q esco
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        header('Location: modify_password.php');
        exit;
    }

    // Imposto l'header della risposta
    header('Content-Type: application/json');
    
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    // Prendo lo user
    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT password FROM users WHERE id = '$userid'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $password = $_GET["q"];

    $exists = false;

    if (mysqli_num_rows($res) > 0) {
    // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
    $entry = mysqli_fetch_assoc($res);
    if (password_verify($password, $entry['password'])) {

      $exists = true;
    }
  }
    

    // Torna un JSON con chiave exists e valore boolean
    echo json_encode(array('exists' => $exists));

    mysqli_close($conn);
?>