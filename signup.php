<?php
require_once 'auth.php';

if (checkAuth()) {
    header("Location: home.php");
    exit;
}

// Verifica l'esistenza di dati POST
if (!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    // Controllo email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Email non valida";
    } else {
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($res) > 0) {
            $error[] = "Email già utilizzata";
        }
    }
    // Controllo password
    if (strlen($_POST["password"]) < 8) {
        $error[] = "La password deve avere almeno 8 caratteri";
    }
    #// Controlla se password coincide con la conferma
    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
        $error[] = "Le password non coincidono";
    }



    // Inserimento nel DB
    if (count($error) == 0) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(email, password) VALUES('$email', '$password')";

        if (mysqli_query($conn, $query)) {
            $_SESSION["user_email"] = $_POST["email"];
            $_SESSION["user_id"] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: personalInfo.php");
            exit;
        } else {
            $error[] = "Errore di connessione al Database";
        }
    }

    mysqli_close($conn);
} else if (isset($_POST["email"])) {
    $error = array("Riempi tutti i campi");
}

?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Signup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="general.css" />
    <link rel="stylesheet" href="login.css" />
    <script src="signup.js" defer></script>
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
    <div class="login">
        <section class="section login_container">
            <?php if (isset($error)) {
                foreach ($error as $err) {
                    echo "<p class='error'>" . $err . "</p>";
                }
            } ?>
            <h1>Iscriviti</h1>
            <form name="signup" action="" method="POST">
                <div class="email">
                    <label>Email <input type="text" name="email" <?php if (isset($_POST["email"])) {
                        echo "value=" . $_POST["email"];
                    } ?>></label>
                    <span class="error"></span>
                </div>
                <div class="password">
                    <label>Password <input type="password" name="password" <?php if (isset($_POST["password"])) {
                        echo "value=" . $_POST["password"];
                    } ?>></label>
                    <span class="error"></span>
                </div>
                <div class="confirm_password">
                    <label>Conferma Password <input type="password" name="confirm_password" <?php if (isset($_POST["confirm_password"])) {
                        echo "value=" . $_POST["confirm_password"];
                    } ?>></label>
                    <span class="error"></span>
                </div>
                <div id="termini">
                    <label><input type='checkbox' name='allow' value="1" <?php if (isset($_POST["allow"])) {
                        echo $_POST["allow"] ? "checked" : "";
                    } ?>>
                        Accetto i termini e condizioni d'uso di TicketOne</label>
                        <span class="error"></span>
                </div>
                <div>
                    <label>&nbsp<button type="submit">Registrati</button></label>
                </div>
            </form>
            <h4>
                Hai già un account? <a href="login.php">Accedi</a>
            </h4>
        </section>
    </div>
    <footer class="footer">
        <img src="imgs/logo_ticketone.jpg" />
        <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
</body>

</html>