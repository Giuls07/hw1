<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>

<html>
    <?php 
        // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar (mobile)
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res);   
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
    <script src="profile.js" defer></script>
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
        <a class="pfp"><img /></a>
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

      <section class="profile section">
        <div id="pfp_chooser">
          <div id="modify_pfp"></div>
        </div>
        <form name="scegli_pfp" action="pfp_save.php" method="POST" id="pfp_popup" class="hidden">
          <div id="pfp_popup_content">
            <span id="close_popup">&times;</span>
            <h2>Modifica Foto Profilo</h2>
            <p>Scegli una nuova foto per il tuo profilo.</p>
            <div id="slideshow_container">
              <button class="arrow prev">&#10094;</button>
              <div id="slide">
                <img>
              </div>              
              <button class="arrow next">&#10095;</button>
            </div>
            <input type="hidden" name="new_pfp" id="new_pfp" value="">
            <button type="submit" class="button">Salva immagine</button>
          </div>
        </form>
        <div class="profile_info">
          <div>
            <h4>Email:</h4>
            <span><?php echo $userinfo['email']?></span>
          </div>
          <div>
            <h4>Nome:</h4>
            <span><?php echo $userinfo['nome']?></span>
          </div>
          <div>
            <h4>Cognome:</h4>
            <span><?php echo $userinfo['cognome']?></span>
          </div>
          <div>
            <h4>Data di nascita:</h4>
            <span><?php echo $userinfo['data_nascita']?></span>
          </div>
          <div>
            <h4>Genere:</h4>
            <span><?php echo $userinfo['genere']?></span>
          </div>
          <div>
            <h4>Paese:</h4>
            <span><?php echo $userinfo['paese']?></span>
          </div>
          <div>
            <h4>Città:</h4>
            <span><?php echo $userinfo['citta']?></span>
          </div>
          <div>
            <h4>Indirizzo:</h4>
            <span><?php echo $userinfo['address']?></span>
          </div>
          <a class="button" href="modify_info.php">Modifica</a>
        </div>
      </section>
      <section class="profile_info">
        <h2>Sicurezza</h2>
        <a href="modify_password.php">Modifica Password</a>
        <a id="delete">Elimina Account</a>
      </section>
      <div id="popup" class="hidden"> 
        <div id="popup_content">
          <h2>Conferma eliminazione</h2>
          <p>Sei sicuro di voler eliminare il tuo account? Questa azione è irreversibile e comporterà la perdita di tutti i tuoi
            dati personali e ordini.</p>
          <form id="popup_buttons" action="delete.php" method="POST">
            <button id="conferma" class="button" type="submit">Sì, eliminalo</button>
            <button id="annulla" class="button" type="button">Annulla</button>
          </form>

        </div>
      </div>
    </div>
    <footer class="footer">
      <img src="imgs/logo_ticketone.jpg" />
      <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
  </body>
</html>

<?php
    // Chiudo la connessione al database
    mysqli_close($conn);
?>
