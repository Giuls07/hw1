<?php
    /*******************************************************
        Controlla che l'email sia unica
    ********************************************************/
    require_once 'configura_db.php';
    
    //se non abbiamo ricevuto una richiesta GET con il parametro q esco
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        header('Location: signup.php');
        exit;
    }

    // Imposto l'header della risposta
    header('Content-Type: application/json');
    
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    // Prendo l'email
    $email = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "SELECT email FROM users WHERE email = '$email'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Torna un JSON con chiave exists e valore boolean
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_close($conn);
?>