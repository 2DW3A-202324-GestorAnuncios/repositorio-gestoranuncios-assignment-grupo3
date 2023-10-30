function validarCampos() {
    var num = 0;

    function showError(element, message) {
        element.innerText = message;
        num++;
    }

    function clearError(element) {
        element.innerText = "";
    }

    // Obtener referencias a los elementos del formulario
    var nombre = document.getElementById('nombre');
    var apellido = document.getElementById('apellido');
    var contrasena = document.getElementById('validar-contraseña');
    var contrasena2 = document.getElementById('validar-contraseña2');
    var usuario = document.getElementById('usuario');
    var email = document.getElementById('email');
    var fecha = document.getElementById('fecha');
    var genero = document.querySelectorAll('input[name="genero"]');
    var terminos = document.getElementById('terminos');

    // Limpiar mensajes de error
    var errorMessages = document.getElementsByClassName('error');
    for (var i = 0; i < errorMessages.length; i++) {
        clearError(errorMessages[i]);
    }

    // Validar nombre
    if (nombre.value.trim() === "") {
        showError(document.getElementById('error6'), "Introduce un nombre");
    }

    // Validar apellido
    if (apellido.value.trim() === "") {
        showError(document.getElementById('error7'), "Introduce un apellido");
    }

    // Validar contraseña
    if (contrasena.value.length < 6) {
        showError(document.getElementById('error3'), "Tu contraseña debe tener al menos 6 caracteres");
    } else if (!/[a-z]/i.test(contrasena.value)) {
        showError(document.getElementById('error3'), "Tu contraseña debe tener al menos una letra minúscula");
    } else if (!/\d/.test(contrasena.value)) {
        showError(document.getElementById('error3'), "Tu contraseña debe tener al menos un dígito");
    } else if (!/[A-Z]/.test(contrasena.value)) {
        showError(document.getElementById('error3'), "Tu contraseña debe tener al menos una letra mayúscula");
    }

    // Confirmar contraseña
    if (contrasena.value !== contrasena2.value) {
        showError(document.getElementById('error4'), "Las contraseñas deben coincidir");
    }

    // Validar usuario
        if (usuario.value.length < 3) {
        showError(document.getElementById('error1'), "El usuario debe tener al menos 3 caracteres");
    } else {
        clearError(document.getElementById('error1'));
    }

    // Validar email
    var emailRE = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    if (!emailRE.test(email.value)) {
        showError(document.getElementById('error2'), "El correo electrónico no es válido");
    }

    // Validar fecha de nacimiento
    if (!fecha.value) {
        showError(document.getElementById('error8'), "Introduce una fecha de nacimiento");
    }

    // Validar género
    var generoChecked = false;
    for (var i = 0; i < genero.length; i++) {
        if (genero[i].checked) {
        generoChecked = true;
        break;
        }
    }
    if (!generoChecked) {
        showError(document.getElementById('error9'), "Selecciona tu género");
    }

    // Validar términos y condiciones
    if (!terminos.checked) {
        showError(document.getElementById('error5'), "Debes aceptar los términos y condiciones");
    }

    // Comprobar si hay errores y cambiar el tipo del botón
    var botonSubmit = document.getElementById('botonSubmit');
    if (num !== 0) {
        botonSubmit.type = "button";
    } else {
        botonSubmit.type = "submit";
    }
}

// Funciones del Login
function toggleDropdown() {
    var formSesion = document.getElementById("form-inicio-sesion");

    if (formSesion.style.display === "none" || formSesion.style.display === "") {
        formSesion.style.display = "block";
    } else {
        formSesion.style.display = "none";
    }
}

function anadirCarritoAndToggleDropdown() {
    // Llama a la función toggleDropdown() directamente
    toggleDropdown();

    // Desplázate hacia la parte superior de la página
    window.scrollTo(0, 0);
}

function mostrarError(mensaje) {
    var mensajeError = document.getElementById("mensaje-error-login");

    mensajeError.textContent = mensaje;
    mensajeError.style.display = "block";
}
