<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if(!empty($_POST["current_password"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    // Controllo password attuale
    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT password FROM users WHERE id = '$userid'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    $current_password = $_POST["current_password"];
    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);
        if (!password_verify($current_password, $entry['password'])) {
            $error[] = "Password attuale errata";
        }
    }

    // Controllo nuova password
    if (strlen($_POST["password"]) < 8) {
        $error[] = "La nuova password deve avere almeno 8 caratteri";
    }
    
    // Controllo conferma password
    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
        $error[] = "Le nuove password non coincidono";
    }

    // Aggiornamento nel DB
    if (count($error) == 0) {
        $new_password = mysqli_real_escape_string($conn, $_POST['password']);
        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        
        $update_query = "UPDATE users SET password='$new_password_hashed' WHERE id='$userid'";
        
        if (mysqli_query($conn, $update_query)) {
            mysqli_close($conn);
            header("Location: profile.php");
            exit;
        }
    }

    mysqli_close($conn);
} else if (isset($_POST["current_password"]) || isset($_POST["password"]) || isset($_POST["confirm_password"])) {
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
    <script src="modify_password.js" defer></script>
    <script src="general.js" defer></script>
    <link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon16x16.png">
    <link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon32x32.png">
</head>

<body class="general">
    <nav class="nav">
      <p class="nav_p">
        Per info e modalità di rimborso
        <a href="https://www.ticketone.it/campaign/info-rimborsi"
          >clicca qui!</a
        >
      </p>
      <div class="flex_nav nav_desktop">
        <a href="index.php" class="nome">ticketone</a>
        <a class="nav_element">Eventi</a>
        <a class="nav_element">Località</a>
        <form class="search_bar">
          <input type="text" placeholder="Ricerca artisti o eventi..." />
          <button type="submit">
            <img src="imgs/magnifying-glass-svgrepo-com.png" />
          </button>
        </form>
        <a class="pfp"><img  /></a>
      </div>
      <div class="flex_nav nav_mobile">
        <div class="mobile_container">
          <a href="index.php" class="nome">ticketone</a>
          <div class="menu_container">
            <a class="pfp"><img  /></a>
            <div class="menu">
              <div></div>
              <div></div>
              <div></div>
            </div>
          </div>
        </div>
        <form class="search_bar">
          <input type="text" placeholder="Ricerca artisti o eventi..." />
          <button type="submit">
            <img src="imgs/magnifying-glass-svgrepo-com.png" />
          </button>
        </form>
      </div>
      <div class="profile_menu_container hidden">
      <h2>My TicketOne</h2>
      <div class="profile_menu">
        <a class="profile_menu_element" data-link="ordini">I tuoi ordini</a>
        <a class="profile_menu_element" href="home.php">Vai alla tua area personale</a>
        <a class="profile_menu_element" href="profile.php">Profilo</a>
        <a href="logout.php" class="button">Logout</a>
    </div>
    </div>
    </nav>
    <div class="hidden mobile_menu_view">
      <div class="mobile_menu_flex">
        <div class="mobile_menu_nav">
          <p>X</p>
        </div>
        <div class="fascetta">
          <div class="selected" data-button="eventi">Eventi</div>
          <div data-button="luoghi">Località</div>
        </div>
        <a class="element_menu" data-type="evento"> Concerti </a>
        <a class="element_menu" data-type="evento"> Teatro </a>
        <a class="element_menu" data-type="evento"> Sport </a>
        <a class="element_menu" data-type="evento"> Mostre e Musei </a>
        <a class="element_menu" data-type="evento"> Altre manifestazioni </a>
        <a class="element_menu" data-type="evento"> Eventi Internazionali </a>
        <a class="element_menu" data-type="evento"> Cinema </a>
        <a class="element_menu" data-type="evento"> Tutti gli eventi </a>

        <a class="element_menu hidden" data-type="località"> Catania </a>
        <a class="element_menu hidden" data-type="località"> Firenze </a>
        <a class="element_menu hidden" data-type="località"> Lucca </a>
        <a class="element_menu hidden" data-type="località"> Milano </a>
        <a class="element_menu hidden" data-type="località"> Roma </a>
        <a class="element_menu hidden" data-type="località"> Taormina </a>
        <a class="element_menu hidden" data-type="località"> Torino </a>
        <a class="element_menu hidden" data-type="località"> Venezia </a>
        <a class="element_menu hidden" data-type="località">
          Tutte le località
        </a>
      </div>
    </div>

    <div class="login">
        <section class="section login_container">
            <?php if (isset($error)) {
                foreach ($error as $err) {
                    echo "<p class='error'>" . $err . "</p>";
                }
            } ?>
            <h1>Cambia password</h1>
            <form name="password_form" action="" method="POST">
                <div class="current_password">
                    <label>Password Attuale <input type="password" name="current_password" <?php if (isset($_POST["current_password"])) {
                        echo "value=" . $_POST["current_password"];
                    } ?>></label>
                    <span class="error"></span>
                </div>
                <div class="password">
                    <label>Nuova Password <input type="password" name="password" <?php if (isset($_POST["password"])) {
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
                <span class="error"></span>
                <div>
                    <label>&nbsp<button type="submit">Cambia Password</button></label>
                </div>
            </form>
        </section>
    </div>
    <footer class="footer">
        <img src="imgs/logo_ticketone.jpg" />
        <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
</body>

</html>