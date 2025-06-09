//*Sezione galleria eventi consigliati
const PHOTO_LIST = [ //Lista foto
    'imgs/Pinguini_tour.jpg',
    'imgs/Lucio_tour.jpeg',
    'imgs/DJO_tour.jpg',
    'imgs/Brunori_tour.jpg',
    'imgs/BeachWeather_tour.jpg',
    'imgs/Mengoni_tour.jpg',
    'imgs/Sabrina_tour.jpg',
    'imgs/Conan_tour.jpg',
    'imgs/MotherMother_tour.jpg'    
];

function createImage(src) {
    const image = document.createElement('img');
    image.src = src;
    return image;
}

const albumView = document.querySelector('#album_view');
for(let i=0; i<PHOTO_LIST.length; i++) {
    const photoSrc = PHOTO_LIST[i];
    const image = createImage(photoSrc);
    image.addEventListener('click', onThumbnailClick);
    albumView.appendChild(image);
} //riempio album

function onThumbnailClick(event) {
    const image = createImage(event.currentTarget.src);
    document.body.classList.add('no_scroll');
    modalView.appendChild(image);
    modalView.classList.remove('hidden');
    
    document.addEventListener('keydown', scroll);
}

function onModalClick() {
    document.body.classList.remove('no_scroll');
    modalView.classList.add('hidden');
    modalView.innerHTML = '';
    document.removeEventListener('keydown', scroll);
}

const modalView = document.querySelector('#modal_view');
modalView.addEventListener('click', onModalClick);

//*Eventi consigliati: scorri tra le foto
function scroll(event) {
    const image = modalView.querySelector('img');
    let newIndex;
    for(let i=0; i<PHOTO_LIST.length; i++) {
        if(image.src.includes(PHOTO_LIST[i])) {
            switch (event.key) {
                case "ArrowLeft":
                    if (i === 0) {
                        newIndex = PHOTO_LIST.length - 1; // Ultimo elemento
                    }
                    else {
                        newIndex = i - 1;
                    };
                    break;

                case "ArrowRight":
                    if (i === PHOTO_LIST.length - 1) {
                        newIndex = 0; // Primo elemento
                    }
                    else {
                        newIndex = i + 1;
                    };
                    break;
            }
        }
    }
    image.src = PHOTO_LIST[newIndex];
}

//* Sezione ordini
function onJsonOrdini(json) {
    console.log(json);
    if(json && json.orders.length > 0) {
        const ordini = document.querySelector('#ordini');
        ordini.innerHTML = ''; // Pulisce la tabella esistente

        const orders = json.orders.reverse().slice(0, 4); // Prende gli ultimi 4 ordini
        for(let i=0; i<orders.length; i++) {
            const div = document.createElement('div');
            div.style.backgroundImage = `url('${orders[i].cover}')`;

            const artist = document.createElement('p');
            artist.textContent = orders[i].artista;

            const data = document.createElement('p');
            data.textContent = orders[i].data;

            div.appendChild(artist);
            div.appendChild(data);
            ordini.appendChild(div);
        }

    }
    else {
        const span = document.querySelector('#ordini span');
        span.textContent = "Non hai ancora effettuato ordini";
    }
}


fetch("get_orders.php").then(onResponse).then(onJsonOrdini);

//* Invio richiesta d'aiuto
const richiestaInput = document.querySelector('#problema');

function checkRichiesta() {
    let count = richiestaInput.value.length;

    let rimaste = richiestaInput.getAttribute('maxlength') - count;
    
    if(rimaste === 0) {
        richiestaInput.classList.add('error_input');
        document.querySelector('#help span').textContent = "Hai superato il numero massimo di caratteri";
    }
    else {
        richiestaInput.classList.remove('error_input');
        document.querySelector('#help span').textContent = "";
    }

}
richiestaInput.addEventListener('input', checkRichiesta);

const helpForm = document.querySelector('#help');

function onJson(json) {
    if(json.status) {
        document.querySelector('#help span').textContent = "Richiesta inviata con successo";
        richiestaInput.value = '';
    } else {
        document.querySelector('#help span').textContent = "Errore nell'invio della richiesta";
    }
}

function onResponse(response){
    if(!response.ok) {
        return null;
    }
    return response.json();
}

function sendRequest(event){
    event.preventDefault();
    fetch("save_request.php", {
        method: 'POST',
        body: new URLSearchParams(new FormData(helpForm))
    }).then(onResponse).then(onJson);
}

helpForm.addEventListener('submit', sendRequest);