function jsonCheckEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.email = !json.exists) {
        // Se non è già stata utilizzata, rimuovo il messaggio di errore e form.Status.email = true
        document.querySelector('.email input').classList.remove('error_input');
        document.querySelector('.email span').textContent = "";
    } else {
        // Altrimenti aggiungo il messaggio di errore
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email input').classList.add('error_input');
    }
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkEmail() {
    const emailInput = document.querySelector('.email input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) {
        //dopo aver controllato il formato dell'email, se non è valido, non faccio la fetch e metto il messaggio di errore
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email input').classList.add('error_input');
        formStatus.email = false;

    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword() {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password input').classList.remove('error_input');
        document.querySelector('.password span').textContent = "";
    } else {
        document.querySelector('.password input').classList.add('error_input');
        document.querySelector('.password span').textContent = "La password deve contenere almeno 8 caratteri";
    }

}

function checkConfirmPassword() {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    if (formStatus.confirmPassword = confirmPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password input').classList.remove('error_input');
        document.querySelector('.confirm_password span').textContent = "";
    } else {
        document.querySelector('.confirm_password input').classList.add('error_input');
        document.querySelector('.confirm_password span').textContent = "Le password non coincidono";
    }
}


function checkSignup(event) {
    const checkbox = document.querySelector('#termini input');
    formStatus[checkbox.name] = checkbox.checked
    if (Object.keys(formStatus).length !== 5 || Object.values(formStatus).includes(false)) {
        event.preventDefault();
    }
}

const formStatus = {'upload': true};
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.querySelector('form').addEventListener('submit', checkSignup);