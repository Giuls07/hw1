<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}
?>

<html>
  <?php
  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
  $query = "SELECT * FROM users WHERE id = '$userid'";
  $result = mysqli_query($conn, $query);
  $userinfo = mysqli_fetch_assoc($result);
  ?>
  <head>
    <title>Mini Homework 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="mhw3.css" />
    <link rel="stylesheet" href="general.css" />
    <script src="mhw3.js" defer></script>
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
    <div class="content">
      <header class="header">
        <h1>My TicketOne, benvenuto nella tua area personale!</h1>
      </header>
      <section class="section">
        <h2>Eventi consigliati</h2>
        <div id="album_view"></div>
        <div id="modal_view" class="hidden"></div>
      </section>
      <section class="section">
        <h2>I tuoi ultimi acquisti</h2>
        <div id="ordini">
          <span></span>
          <!-- <div id="Mahmood">
            <p>
              Mahmood <br />
              20/08/2024
            </p>
          </div>
          <div id="Tananai">
            <p>
              Tananai <br />
              11/08/2023
            </p></div>
          <div id="Blanco">
            <p>
              Blanco <br />
              30/07/2022
            </p>
          </div>
          <div>
            <p id="ecc" data-link="ordini">...</p>
          </div> -->
        </div>
      </section>
      <section class="section">
        <div id="contenitore">
          <div class="card">
            <h3>Dati personali e consensi</h3>
            <div class="card_content">
              <p>
                <?php 
                if(empty($userinfo['nome']) || empty($userinfo['cognome'])) {
                  echo 'Inserire nome e cognome nelle informazioni del profilo';
                }
                else if($userinfo['genere'] === 'm') {
                  echo 'Signor ' . $userinfo['nome'] . ' ' . $userinfo['cognome'];
                }
                else if($userinfo['genere'] === 'f') {
                  echo 'Signora ' . $userinfo['nome'] . ' ' . $userinfo['cognome'];
                }
                else {
                  echo $userinfo['nome'] . ' ' . $userinfo['cognome'];
                }
                ?>
              </p>
              <p>Data di nascita: 
                <?php 
                if($userinfo['data_nascita'] === '0000-00-00') {
                  echo 'Non specificata';
                }
                else {
                  echo date('d/m/Y', strtotime($userinfo['data_nascita']));
                }
                ?>
              </p>
              <a href="profile.php">Modifica</a>
            </div>
          </div>
          <div class="card">
            <h3>Le tue Newsletters</h3>
            <div class="card_content">
              <p>
                Dicci cosa ti piace e ti invieremo regolarmente il meglio di
                eventi e dei tuoi artisti preferiti
              </p>
              <a>Modifica</a>
            </div>
          </div>
          <div class="card">
            <h3>Cambio nominativo</h3>
            <div class="card_content">
              <p>Accedi al processo di ripersonalizzazione del biglietto</p>
              <a>Cambia nome</a>
            </div>
          </div>
        </div>
      </section>
      <section class="section" id="help_section">
        <form name="help_form" action="" method="POST" id="help">
          <h3>Se hai bisogno di aiuto, contattaci</h3>
          <span id="errore"></span>
          <textarea name="richiesta" placeholder="Descrivi il problema" maxlength="1000" id="problema" ></textarea>
          <button type="submit">Invia</button>
        </form>
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