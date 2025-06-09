<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
$userid = mysqli_real_escape_string($conn, $userid);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $query1 = "UPDATE users SET email='$email', nome='$name', cognome='$surname', data_nascita='$birthdate', genere='$gender', paese='$country', citta='$city', address='$address' WHERE id=$userid";
    if (mysqli_query($conn, $query1)) {
        mysqli_close($conn);
        header("Location: profile.php");
        exit;
    }
}
?>

<html>
    <?php
// Query per ottenere le informazioni dell'utente
$query = "SELECT * FROM users WHERE id = $userid";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$userinfo = mysqli_fetch_assoc($result);
    ?>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="profile.css" />
    <link rel="stylesheet" href="general.css" />
    <script src="general.js" defer></script>
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="imgs/favicon16x16.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="imgs/favicon32x32.png"
    />
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
    <div class="content">
      <header class="header">
        <h1>Informazioni Personali</h1>
      </header>

      <section class="profile">
        <div id="modify_info">
          <h3>Modifica informazioni</h3>
            <form name="info" action="" method="POST">
                <label>Email:<input type="text" name="email" value="<?php echo $userinfo['email'] ?>" /> </label>
                <label>Nome:<input type="text" name="name" value="<?php echo $userinfo['nome'] ?>" /> </label>
                <label>Cognome:<input type="text" name="surname" value="<?php echo $userinfo['cognome'] ?>" />
                </label>
                <label>Data di nascita:
                    <input type="date" name="birthdate" value="<?php echo $userinfo['data_nascita'] ?>" />
                </label>
                <label>Genere:
                    <div>
                        <label>Maschio<input type="radio" name="gender" value="m" <?php if ($userinfo['genere'] === 'm')
                            echo 'checked'; ?> /></label>
                        <label>Femmina<input type="radio" name="gender" value="f" <?php if ($userinfo['genere'] === 'f')
                            echo 'checked'; ?> /></label>
                        <label>Non-binario<input type="radio" name="gender" value="nb" <?php if ($userinfo['genere'] === 'nb')
                            echo 'checked'; ?> /></label>
                        <label>Preferisco non rispondere<input type="radio" name="gender" value="na" <?php if ($userinfo['genere'] === 'na')
                            echo 'checked'; ?> /></label>
                    </div>
                </label>
                <label>Paese:<select name="country">
                        <option value=""></option>
                        <option value="fr" <?php if ($userinfo['paese'] === 'fr')
                            echo 'selected'; ?>>Francia</option>
                        <option value="de" <?php if ($userinfo['paese'] === 'de')
                            echo 'selected'; ?>>Germania</option>
                        <option value="it" <?php if ($userinfo['paese'] === 'it')
                            echo 'selected'; ?>>Italia</option>
                        <option value="es" <?php if ($userinfo['paese'] === 'es')
                            echo 'selected'; ?>>Spagna</option>
                        <option value="ch" <?php if ($userinfo['paese'] === 'ch')
                            echo 'selected'; ?>>Svizzera</option>
                        <option value="uk" <?php if ($userinfo['paese'] === 'uk')
                            echo 'selected'; ?>>Regno Unito</option>
                        <option value="us" <?php if ($userinfo['paese'] === 'us')
                            echo 'selected'; ?>>USA</option>
                    </select></label>
                <label>Città:<input type="text" name="city" value="<?php echo $userinfo['citta'] ?>"/>
                </label>
                <label>Indirizzo:<input type="text" name="address" value="<?php echo $userinfo['address'] ?>" /></label>
                <button type="submit">Salva</button>
            </form>
        </div>
      </section>
    </div>
    <footer class="footer">
      <img src="imgs/logo_ticketone.jpg" />
      <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
  </body>
</html>
<?php
mysqli_close($conn);
?>