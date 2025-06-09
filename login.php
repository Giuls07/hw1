<?php
// Verifica che l'utente sia già loggato, in caso positivo va direttamente alla home
include 'auth.php';
if (checkAuth()) {
  header('Location: home.php');
  exit;
}

// Inizializzo la variabile di errore
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
  // Se username e password sono stati inviati
  // Connessione al DB
  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  // ID e Username per sessione, password per controllo
  $query = "SELECT * FROM users WHERE email = '" . $email . "'";
  // Esecuzione
  $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
  ;

  if (mysqli_num_rows($res) > 0) {
    // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
    $entry = mysqli_fetch_assoc($res);
    if (password_verify($_POST['password'], $entry['password'])) {

      // Imposto una sessione dell'utente
      $_SESSION["user_email"] = $entry['email'];
      $_SESSION["user_id"] = $entry['id'];
      header("Location: home.php");
      mysqli_free_result($res);
      mysqli_close($conn);
      exit;
    }
  }
  // Se l'utente non è stato trovato o la password non ha passato la verifica
  $error = "Email e/o Password errati.";
} else if (isset($_POST["username"]) || isset($_POST["password"])) {
  // Se solo uno dei due è impostato
  $error = "Inserisci email e password.";
}
?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="general.css" />
    <link rel="stylesheet" href="login.css" />
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
      <div class="flex_nav">
        <a href="index.php" class="nome">ticketone</a>
        <a class="account" href="login.php"><img src="imgs/person.png" /></a>
      </div>
    </nav>
    <div class="login">
      <section class="section login_container">
        <?php if (isset($error)) {
                    echo "<p class='error'>" . $error . "</p>";
            } ?>
        <h1>Login</h1>
        <form name="login" action="" method="POST">
          <div>
            <label>Email <input type="text" name="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></label>
          </div>
          <div>
            <label>Password <input type="password" name="password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></label>
        </div>
          <div>
            <label>&nbsp<button type="submit">Login</button></label>
          </div>
        </form>
        <h4>
          Non hai un account? <a href="signup.php">Registrati</a>
        </h4>
      </section>
    </div>
    <footer class="footer">
      <img src="imgs/logo_ticketone.jpg" />
      <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
  </body>
</html>