let token;

function onJson(json) {
        console.log('Login riuscito! Token:', json.token);
        window.location.href = "mhw3.html";
}

function onResponse(response) {
    if (response.ok) {
        return response.json();
    }
    else {
        response.json().then((data) => {
            alert('Login fallito: ' + data.error);
        });
        return;
    }
};

function onFormSubmit(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert('Email e Password obbligatori!');
        return;
    }

    fetch('https://reqres.in/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'x-api-key': 'reqres-free-v1'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    }).then(onResponse).then(onJson);
};

const loginForm = document.querySelector('form');
loginForm.addEventListener('submit', onFormSubmit); 