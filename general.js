//* Sezione menu a scomparsa per mobile
const menu = document.querySelector(".menu");
const menuTendina = document.querySelector(".mobile_menu_view");
const chiudi = document.querySelector(".mobile_menu_nav p");

function chiudiMenu(){
    menuTendina.classList.add("hidden");
    document.body.classList.remove("no_scroll");
    chiudi.removeEventListener("click", chiudiMenu);
}

function apriMenu(){
    menuTendina.classList.remove("hidden");
    document.body.classList.add("no_scroll");
    chiudi.addEventListener("click", chiudiMenu);
}

menu.addEventListener("click", apriMenu);

//*Toggle in fascetta
const eventi = document.querySelector('[data-button="eventi"]');
const luoghi = document.querySelector('[data-button="luoghi"]');
const events = document.querySelectorAll('[data-type="evento"]');
const località = document.querySelectorAll('[data-type="località"]');

function selectLocalità(){
    eventi.classList.remove("selected");
    luoghi.classList.add("selected");
    
    for(let event of events){
        event.classList.add("hidden");
    }

    for(let place of località){
        place.classList.remove("hidden");
    }
}

function selectEventi(){
    eventi.classList.add("selected");
    luoghi.classList.remove("selected");
    
    for(let event of events){
        event.classList.remove("hidden");
    }

    for(let place of località){
        place.classList.add("hidden");
    }
}

eventi.addEventListener("click", selectEventi);
luoghi.addEventListener("click", selectLocalità);

//*Sezione menù profilo
const contenutoPagina = document.querySelector(".content");
const pfp = document.querySelectorAll(".pfp");
const menuProfilo = document.querySelector(".profile_menu_container");

function apriMenuProfilo(){
    menuProfilo.classList.remove("hidden");
    document.body.classList.add("no_scroll");
    pfp.forEach(p => {
        p.removeEventListener("click", apriMenuProfilo);
    });
    pfp.forEach(p => {
        p.addEventListener("click", chiudiMenuProfilo);
    });
    contenutoPagina.addEventListener("click", chiudiMenuProfilo);
}

function chiudiMenuProfilo(){
    menuProfilo.classList.add("hidden");
    document.body.classList.remove("no_scroll");
    pfp.forEach(p => {
        p.addEventListener("click", apriMenuProfilo);
    });
    pfp.forEach(p => {
        p.removeEventListener("click", chiudiMenuProfilo);
    });
    contenutoPagina.removeEventListener("click", chiudiMenuProfilo);
}

pfp.forEach(p => {
    p.addEventListener("click", apriMenuProfilo);
});


//* Sezione caricamento foto profilo
const avatar = document.querySelectorAll('.pfp img');

// Funzione per aggiornare l'immagine del profilo
function onJSONPfp(json) {
    if(json.pfp){
        avatar.forEach(img => {
            img.src = json.pfp;
        });
    }
}

function onResponsePfp(response) {
    if (!response.ok) return null;
    return response.json();
}


fetch('get_pfp.php').then(onResponsePfp).then(onJSONPfp);

//* Ricerca eventi
function search(event) {
    event.preventDefault();
    let query = event.currentTarget.querySelector('input').value;
    if (query) {
      window.location.href = `results.php?q=${encodeURIComponent(query)}`;
    }
}
const form = document.querySelectorAll('.search_bar');
form.forEach(f => {
    f.addEventListener('submit', search);
});