function jsonCheckNewPassword(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.password = !json.exists) {
        // Se non è già stata utilizzata, rimuovo il messaggio di errore e form.Status.email = true
        document.querySelector('.password input').classList.remove('error_input');
        document.querySelector('.password span').textContent = "";
    } else {
        // Altrimenti aggiungo il messaggio di errore
        document.querySelector('.password span').textContent = "La password è quella attualmente in uso";
        document.querySelector('.password input').classList.add('error_input');
    }
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkPassword() {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        fetch("check_password.php?q="+encodeURIComponent(String(passwordInput.value))).then(fetchResponse).then(jsonCheckNewPassword);
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


function checkForm(event) {
    if (Object.keys(formStatus).length !== 4 || Object.values(formStatus).includes(false)) {
        event.preventDefault();
    }
}

const formStatus = {'upload': true};
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.querySelector('form').addEventListener('submit', checkForm);