<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: home.php");
    exit;
}
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet"
        />
        <link rel="stylesheet" href="general.css" />
        <link rel="stylesheet" href="results.css" />
        <script src="results.js" defer></script>
        <title>Risultati ricerca</title>
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
                <button type="submit"><img src="imgs/magnifying-glass-svgrepo-com.png" /></button>
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
        
        <div class="content">        
                <header class="header">
                    <h1>Risultati ricerca per: <span id="ricerca"></span></h1>
                </header>
                <section id="results" class="section">
                    <div>
                        <p class="selected_search" data-search="eventi">Eventi</p>
                        <p data-search="artisti">Artisti</p>
                    </div>
                    <div id="results_container">

                    </div>
                </section>
        </div>
        <footer class="footer">
        <img src="imgs/logo_ticketone.jpg" />
        <p>© 2021 TicketOne S.p.A. - P.IVA 1234567890</p>
    </footer>
    </body>
</html>