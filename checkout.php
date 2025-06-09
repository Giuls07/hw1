<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}



?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Evento</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="general.css" />
    <link rel="stylesheet" href="checkout.css">
    <script src="general.js" defer></script>
    <script src="checkout.js" defer></script>
    <link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="imgs/favicon32x32.png">
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
          <button type="submit"><img src="imgs/magnifying-glass-svgrepo-com.png"/></button>
        </form>
        <a class="pfp"><img /></a>
      </div>
      <div class="flex_nav nav_mobile">
        <div class="mobile_container">
          <a href="index.php" class="nome">ticketone</a>
          <div class="menu_container">
            <a class="pfp"><img /></a>
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
          <a class="profile_menu_element" href="home.php"
            >Vai alla tua area personale</a
          >
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
          <a class="element_menu" data-type="evento">
            Altre manifestazioni
          </a>
          <a class="element_menu" data-type="evento">
            Eventi Internazionali
          </a>
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
          <a class="element_menu hidden" data-type="località"> Tutte le località </a>
        </div>
    </div>

    <div id="checkout">
        <div id="checkout_container">
            <h1>Pagamento Evento</h1>
            <form name="checkout_form" action="compra.php" method="POST">
                <div class="form_group">
                    <label for="nome">Nome Titolare</label>
                    <input type="text" id="nome" name="nome" placeholder="Mario Rossi">
                    <span class="error" id="nome_error"></span>
                </div>

                <div class="form_group">
                    <label for="numero_carta">Numero Carta</label>
                    <input type="text" id="numero_carta" name="numero_carta" maxlength="19" placeholder="1234 5678 9012 3456">
                    <span class="error" id="numero_error"></span>
                </div>

                <div class="form_group">
                    <label >Data di scadenza</label>
                    <div id="scadenza_carta">
                        <input type="text" id="mese_scadenza" name="mese_scadenza" maxlength="2" placeholder="MM">
                        <input type="text" id="anno_scadenza" name="anno_scadenza" maxlength="2" placeholder="AA">
                    </div>
                    <span class="error" id="scadenza_error"></span>
                </div>

                <div class="form_group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123">
                    <span class="error" id="cvv_error"></span>
                </div>

                <div id="checkout_summary">
                    <div><p>Artista:</p> <span id="artista"></span></div>
                    <input type="hidden" name="artista" value="" id="artista_hidden">
                    <div><p>Data:</p> <span id="data"></span></div>
                    <input type="hidden" name="data" value="" id="data_hidden">
                    <div><p>Ora:</p> <span id="ora"></span></div>
                    <input type="hidden" name="ora" value="" id="ora_hidden">
                    <div><p>Prezzo:</p> <span id="prezzo"></span></div>
                    <input type="hidden" name="prezzo" value="" id="prezzo_hidden">
                </div>
                <input type="hidden" name="immagine" value="" id="immagine">

                <button type="submit" class="button">Conferma Pagamento</button>
            </form>
        </div>
    </div>
    <footer class="footer">
      <img src="imgs/logo_ticketone.jpg" />
      <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
</body>
</html>
