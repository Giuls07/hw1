<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
$userid = mysqli_real_escape_string($conn, $userid);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query1 = "UPDATE users SET nome='$name', cognome='$surname', data_nascita='$birthdate', genere='$gender', paese='$country', citta='$city', address='$address' WHERE id=$userid";
    if (mysqli_query($conn, $query1)) {
        mysqli_close($conn);
        header("Location: home.php");
        exit;
    }
}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Informazioni Personali</title>
    <link rel="stylesheet" href="general.css" />
    <link rel="stylesheet" href="info.css" />
    <link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon16x16.png">
    <link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon32x32.png">
</head>

<body class="general">
    <nav class="nav">
        <p class="nav_p">
            Per info e modalità di rimborso
            <a href="https://www.ticketone.it/campaign/info-rimborsi">clicca qui!</a>
        </p>
        <div class="flex_nav">
            <a href="index.php" class="nome">ticketone</a>
            <a class="account" href="login.php"><img src="imgs/person.png" /></a>
        </div>
    </nav>
    <div class="content">
        <section id="info" class="section">
            <h1>Informazioni Personali</h1>
            <form name="info" action="" method="POST">
                <label>Nome:<input type="text" name="name" value="" /> </label>
                <label>Cognome:<input type="text" name="surname" value="" />
                </label>
                <label>Data di nascita:
                    <input type="date" name="birthdate" value="" />
                </label>
                <label>Genere:
                    <div>
                        <label>Maschio<input type="radio" name="gender" value="m" /></label>
                        <label>Femmina<input type="radio" name="gender" value="f" /></label>
                        <label>Non-binario<input type="radio" name="gender" value="nb"/></label>
                        <label>Preferisco non rispondere<input type="radio" name="gender" value="na"/></label>
                    </div>
                </label>
                <label>Paese:<select name="country">
                        <option value=""></option>
                        <option value="fr" >Francia</option>
                        <option value="de" >Germania</option>
                        <option value="it" >Italia</option>
                        <option value="es" >Spagna</option>
                        <option value="ch" >Svizzera</option>
                        <option value="uk" >Regno Unito</option>
                        <option value="us" >USA</option>
                    </select></label>
                <label>Città:<input type="text" name="city" value=""/>
                </label>
                <label>Indirizzo:<input type="text" name="address" value="" /></label>
                <button type="submit">Continua</button>
            </form>
        </section>
    </div>

    <footer class="footer">
        <img src="imgs/logo_ticketone.jpg" />
        <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
</body>

</html>