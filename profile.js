//*Elimina Account
const popup = document.querySelector('#popup');

function showPopup() {
    popup.classList.remove('hidden');
    document.body.classList.add('no_scroll');
}

function hidePopup() {
    popup.classList.add('hidden');
    document.body.classList.remove('no_scroll');
}

document.querySelector('#delete').addEventListener('click', showPopup);
document.querySelector('#annulla').addEventListener('click', hidePopup);


//*Cambia Avatar
const PFP_LIST = [ // Lista di avatar disponibili
    'pfps/skelly.jpeg',
    'pfps/cat.jpeg',
    'pfps/jake.jpeg',
    'pfps/spongebob.jpeg',
    'pfps/notes.jpeg'
]

// const pagina = document.querySelector(".content");
const chooser = document.querySelector('#pfp_chooser');
const avatarPopup = document.querySelector('#pfp_popup');
document.querySelector('#close_popup').addEventListener('click', hideAvatarPopup);
const img = avatarPopup.querySelector('#slide img');
const hiddenInput = document.querySelector('#new_pfp');

function showAvatarPopup() {
    img.src = PFP_LIST[0]; // Imposta l'immagine iniziale
    hiddenInput.value = PFP_LIST[0]; // Imposta il valore dell'input nascosto

    avatarPopup.classList.remove('hidden');
    document.body.classList.add('no_scroll');
}

function hideAvatarPopup() {
    avatarPopup.classList.add('hidden');
    document.body.classList.remove('no_scroll');
}

chooser.addEventListener('click', showAvatarPopup);

const prev = avatarPopup.querySelector('.prev');
const next = avatarPopup.querySelector('.next');

function nextPfp(event) {
    event.preventDefault(); // Previene il comportamento predefinito del link
    let newIndex;
    for(let i = 0; i < PFP_LIST.length; i++)
    {
        if (img.src.includes(PFP_LIST[i])) {
            if( i === PFP_LIST.length - 1) {
                newIndex = 0; // Torna al primo avatar
            }
            else {
                newIndex = i + 1; // Passa al prossimo avatar
            }
        }
    }
    img.src = PFP_LIST[newIndex];
    hiddenInput.value = PFP_LIST[newIndex]; // Aggiorna il valore dell'input nascosto
}

function prevPfp(event) {
    event.preventDefault();
    let newIndex;
    for(let i = 0; i < PFP_LIST.length; i++)
    {
        if (img.src.includes(PFP_LIST[i])) {
            if( i === 0) {
                newIndex = PFP_LIST.length - 1; // Torna all'ultimo avatar
            }
            else {
                newIndex = i - 1; // Torna al precedente avatar
            }
        }
    }
    img.src = PFP_LIST[newIndex];
    hiddenInput.value = PFP_LIST[newIndex]; // Aggiorna il valore dell'input nascosto
}

prev.addEventListener('click', prevPfp);
next.addEventListener('click', nextPfp);

//*Personalizza Avatar
function OnJSONAvatar(json) {
    if(json.pfp){
        chooser.style.backgroundImage = `url(${json.pfp})`;
    }
}

function onResponseAvatar(response) {
    if (!response.ok) return null;
    return response.json();
}

fetch("get_pfp.php").then(onResponseAvatar).then(OnJSONAvatar);