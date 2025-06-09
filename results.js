//*Ricerca
function onJsonEvents(json) {
    const resultsContainer = document.querySelector('#results_container');
    resultsContainer.innerHTML = ''; // Pulisce i risultati precedenti
    
    for (let i = 0; i < json._embedded.events.length; i++) {
        const event = json._embedded.events[i];
        const div = document.createElement('div');
        div.classList.add('result_item');
        div.dataset.id = event.id; // Aggiungo l'ID dell'evento per il click
        div.dataset.type = 'concerto'; // Aggiungo il tipo di risultato
        const name = document.createElement('h2');
        name.textContent = event.name;
        const date = document.createElement('p');
        date.textContent = event.dates.start.localDate + ' ' + event.dates.start.localTime;
        const venue = document.createElement('p');
        venue.textContent = event._embedded.venues[0].name + ', ' + event._embedded.venues[0].city.name;
        const image = document.createElement('img');
        image.src = event.images[0].url;
        const caption = document.createElement('div');
        caption.classList.add('caption_container');
        caption.appendChild(name);
        caption.appendChild(date);
        caption.appendChild(venue);
        div.appendChild(image);
        div.appendChild(caption);
        resultsContainer.appendChild(div);
        div.addEventListener('click', onProductClick)
    }
}

function onResponse(response) {
    return response.json();
}

function searchEvents(ricerca) {
    const search_value = encodeURIComponent(ricerca);
    const API_key = 'yQiK3OUJWbGAqNUhH2uNqnh1ALUayhQI';
    const search_url = 'https://app.ticketmaster.com/discovery/v2/events.json?size=10&apikey=' + API_key + '&keyword=' + search_value + '&sort=date,asc&locale=*';
    fetch(search_url).then(onResponse).then(onJsonEvents);
}

function search(event) {
    event.preventDefault();
    const query = event.currentTarget.querySelector('input').value;
    if (query) {
      window.location.href = 'results.php?q=' + encodeURIComponent(query);
    }
}

function searchEventi(){
    search_eventi.classList.add("selected_search");
    search_artisti.classList.remove("selected_search");
    searchEvents(ricerca); 
}

const form = document.querySelectorAll('.search_bar');
form.forEach(f => {
    f.addEventListener('submit', search);
});

let params = new URLSearchParams(window.location.search);
let ricerca = params.get('q');
document.getElementById('ricerca').textContent = ricerca;
searchEvents(ricerca); //Chiama l'API per i risultati

//*Ricerca artista
function onJsonArtisti(json) {
    const resultsContainer = document.querySelector('#results_container');
    resultsContainer.innerHTML = ''; // Pulisce i risultati precedenti
    search_eventi.classList.remove("selected_search");
    search_artisti.classList.add("selected_search");
    
    for (let i = 0; i < json._embedded.attractions.length; i++) {
        const artist = json._embedded.attractions[i];
        const div = document.createElement('div');
        div.classList.add('result_item');
        const name = document.createElement('h2');
        name.textContent = artist.name;
        const image = document.createElement('img');
        image.src = artist.images[0].url;
        const caption = document.createElement('div');
        caption.classList.add('caption_container');
        caption.appendChild(name);
        div.appendChild(image);
        div.appendChild(caption);
        resultsContainer.appendChild(div);
    }
}

function searchArtists(ricerca) {
    const search_value = encodeURIComponent(ricerca);
    const API_key = 'yQiK3OUJWbGAqNUhH2uNqnh1ALUayhQI';
    const search_url = 'https://app.ticketmaster.com/discovery/v2/attractions.json?size=1&apikey=' + API_key + '&keyword=' + search_value + '&locale=*';
    fetch(search_url).then(onResponse).then(onJsonArtisti);
}
const search_eventi = document.querySelector('[data-search="eventi"]');
const search_artisti = document.querySelector('[data-search="artisti"]');

function searchArtisti(){
    searchArtists(ricerca);
}

search_artisti.addEventListener("click", searchArtisti);
search_eventi.addEventListener("click", searchEventi);

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

//* Manda a pagina checkout
function onProductClick(event) {
    window.location.href = 'checkout.php?prodotto=' + encodeURIComponent(event.currentTarget.dataset.id);
}