//*Controllo carta di credito
const nome = document.querySelector('#nome');
const num = document.querySelector('#numero_carta');
const mese = document.querySelector('#mese_scadenza');
const anno = document.querySelector('#anno_scadenza');
const cvv = document.querySelector('#cvv');

function checkNome() {
    if(formStatus.nome = nome.value.length > 0) {
        nome.classList.remove('error_input');
        document.querySelector('#nome_error').textContent = "";
    }
    else {
        nome.classList.add('error_input');
        document.querySelector('#nome_error').textContent = "Il nome non può essere vuoto";
    }
}

function checkNumeroCarta() {
    if(formStatus.numero_carta = /^(\d{4} ?){4}$/.test(num.value)) {
        num.classList.remove('error_input');
        document.querySelector('#numero_error').textContent = "";
    } else {
        num.classList.add('error_input');
        document.querySelector('#numero_error').textContent = "Il numero della carta deve essere di 16 cifre";
    }
}

function checkScadenza() {
    const currentYear = new Date().getFullYear() % 100; // Ottieni l'anno corrente in formato YY
    const currentMonth = new Date().getMonth() + 1; // Ottieni il mese corrente (1-12)

    if (mese.value < 1 || mese.value > 12) {
        mese.classList.add('error_input');
        document.querySelector('#scadenza_error').textContent = "Il mese deve essere tra 1 e 12";
        formStatus.mese = false;
        return;
    } else {
        mese.classList.remove('error_input');
        document.querySelector('#scadenza_error').textContent = "";
        formStatus.mese = true;
    }

    if (anno.value < currentYear || (anno.value == currentYear && mese.value < currentMonth)) {
        anno.classList.add('error_input');
        mese.classList.add('error_input');
        document.querySelector('#scadenza_error').textContent = "La carta è scaduta";
        formStatus.anno = false;
    } else {
        anno.classList.remove('error_input');
        mese.classList.remove('error_input');
        document.querySelector('#scadenza_error').textContent = "";
        formStatus.anno = true;
    }

    if (mese.value.length === 0 || anno.value.length === 0) {
        mese.classList.add('error_input');
        anno.classList.add('error_input');
        document.querySelector('#scadenza_error').textContent = "Il mese e l'anno non possono essere vuoti";
        formStatus.mese = false;
        formStatus.anno = false;
    }
}

function checkCVV() {
    if(formStatus.cvv = /^\d{3}$/.test(cvv.value)) {
        cvv.classList.remove('error_input');
        document.querySelector('#cvv_error').textContent = "";
    } else {
        cvv.classList.add('error_input');
        document.querySelector('#cvv_error').textContent = "Il CVV deve essere di 3 cifre";
    }
}

function checkForm(event) {
    if (Object.keys(formStatus).length !== 6 || Object.values(formStatus).includes(false)) {
        event.preventDefault();
    }
}

const formStatus = {'upload': true};
nome.addEventListener('blur', checkNome);
num.addEventListener('blur', checkNumeroCarta);
mese.addEventListener('blur', checkScadenza);
anno.addEventListener('blur', checkScadenza);
cvv.addEventListener('blur', checkCVV);
document.querySelector('form').addEventListener('submit', checkForm);

//*Caricamento dettagli evento
let params = new URLSearchParams(window.location.search);
let id = params.get('prodotto');

function onJsonInfo(json) {
    console.log(json);
    const nome_artista = document.querySelector('#artista');
    const data = document.querySelector('#data');
    const ora = document.querySelector('#ora');
    const prezzo = document.querySelector('#prezzo');
    const immagine = document.querySelector('#immagine');
    const artista_hidden = document.querySelector('#artista_hidden');
    const data_hidden = document.querySelector('#data_hidden');
    const ora_hidden = document.querySelector('#ora_hidden');
    const prezzo_hidden = document.querySelector('#prezzo_hidden');

    if(json){
        nome_artista.textContent = json._embedded.attractions[0].name;
        artista_hidden.value = json._embedded.attractions[0].name;

        const dateTime = new Date(json.dates.start.localDate + ' ' + json.dates.start.localTime);

        data.textContent = dateTime.toLocaleDateString('it-IT', {day: '2-digit', month: 'long', year: 'numeric'});
        data_hidden.value = dateTime.toLocaleDateString('it-IT', {day: '2-digit', month: '2-digit', year: 'numeric'});

        ora.textContent = dateTime.toLocaleTimeString('it-IT', {hour: '2-digit', minute: '2-digit'});
        ora_hidden.value = dateTime.toLocaleTimeString('it-IT', {hour: '2-digit', minute: '2-digit', second: '2-digit'});

        if (json.priceRanges && json.priceRanges.length > 0) {
            prezzo.textContent = json.priceRanges[0].currency + ' ' + json.priceRanges[0].min + ' - ' + json.priceRanges[0].max;
        } else {
            prezzo.textContent = "Prezzo non disponibile";
        }
        prezzo_hidden.value = prezzo.textContent;

        immagine.value = json.images[0].url;
    }
}

function onResponseInfo(response) {
    if (!response.ok) {
        return null;
    }
    return response.json();
}

const search_value = encodeURIComponent(id);
const API_key = 'yQiK3OUJWbGAqNUhH2uNqnh1ALUayhQI';
const search_url = 'https://app.ticketmaster.com/discovery/v2/events/' + search_value + '.json?apikey=' + API_key;
fetch(search_url).then(onResponseInfo).then(onJsonInfo);