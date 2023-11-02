// Creamos la funcion para validar el formulario de registro
function validarCampos() {
    // Creamos una variable llamada "errorNum" que aumentara si hay errores
    var errorNum = 0;

    //Creamos una funcion interna que muestra el mensaje debajo de cada elemento y incrementamos la variable "errorNum"
    function showError(element, message) {
        element.innerText = message;
        errorNum++;
    }

    // Utilizamos variables que hacen referencias a los elementos del formulario
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

    // Confirmar segunda contraseña
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
    // Validar género vacio
    if (!generoChecked) {
        showError(document.getElementById('error9'), "Selecciona tu género");
    }

    // Creamos otra funcion interna que elimina el mensaje de error
    function clearError(element) {
        element.innerText = "";
    }
}

// Funcion para mostrar el desplegable del Login
function formularioInicioSession() {
    var formSesion = document.getElementById("form-inicio-sesion");

    if (formSesion.style.display === "none" || formSesion.style.display === "") {
        formSesion.style.display = "block";
    } else {
        formSesion.style.display = "none";
    }
}

// Funcion que al no estar con la session iniciada saca el "formularioInicioSession" cuando se hace click en el boton de añadir carrito
function anadirCarritoFormularioInicioSession() {
    // Llama a la función toggleDropdown() directamente
    formularioInicioSession();

    // Desplázate hacia la parte superior de la página
    window.scrollTo(0, 0);
}

// Funcion que muestra el error en el formulario de inicio sesion
function mostrarError(mensaje) {
    var mensajeError = document.getElementById("mensaje-error-login");

    mensajeError.textContent = mensaje;
    mensajeError.style.display = "block";
}

// Función para eliminar un producto del carrito
function eliminarProducto(id) {
    carrito = carrito.filter(producto => producto.id !== id);
    actualizarCarrito();

    let numeroCarrito = document.getElementById('numero-carrito');
    numeroCarrito.innerText = parseInt(numeroCarrito.innerText) - 1;
}

// Función para actualizar el carrito en el Local Storage y en la interfaz de usuario
function actualizarCarrito() {
    localStorage.setItem('carrito => ' + usuario, JSON.stringify(carrito));

    // Limpiar la vista del carrito
    const carritoContainer = document.getElementById("carrito-items");
    carritoContainer.innerHTML = "";

    // Reiniciar los totales
    let precioTotal = 0.0; // Inicializar como número de punto flotante
    let totalProductos = 0;

    // Recrear la vista del carrito con los productos actualizados
    carrito.forEach(producto => {
        const itemContainer = document.createElement("div");
        itemContainer.classList.add("carrito-item");

        const fotoCarrito = document.createElement("div");
        fotoCarrito.classList.add("foto-carrito");
        fotoCarrito.innerHTML = `<img src="img/anuncios/${producto.foto}" alt="${producto.nombre}">`;

        const carritoContent = document.createElement("div");
        carritoContent.classList.add("carrito-content");
        // Reemplazar el punto por coma en la representación del precio
        const precioConComa = parseFloat(producto.precio).toFixed(2).replace(".", ",");
        carritoContent.innerHTML = `
            <p class="producto-nombre">${producto.nombre}</p>
            <p class="producto-descripcion">${producto.descripcion}</p>
            <p>Precio: <span class="producto-precio">${precioConComa} €</span></p>
        `;

        const eliminarButton = document.createElement("button");
        eliminarButton.classList.add("eliminar-button");
        eliminarButton.setAttribute("data-id", producto.id);
        eliminarButton.innerHTML = '<img src="img/papelera.png" alt="Eliminar" width="40px" heigth="40px">';
        eliminarButton.addEventListener('click', () => eliminarProducto(producto.id));

        itemContainer.appendChild(fotoCarrito);
        itemContainer.appendChild(carritoContent);
        itemContainer.appendChild(eliminarButton);

        carritoContainer.appendChild(itemContainer);

        // Actualizar los totales
        precioTotal += parseFloat(producto.precio); // Convertir a número de punto flotante
        totalProductos++;
    });

    // Reemplazar el punto por coma en la representación del precio total
    const precioTotalConComa = precioTotal.toFixed(2).replace(".", ",");
    
    // Actualizar la interfaz con los totales
    const totalPrecioElement = document.getElementById("total-precio");
    const totalProductosElement = document.getElementById("total-productos");

    totalPrecioElement.innerText = precioTotalConComa + " €";
    totalProductosElement.innerText = totalProductos + " productos";

    if (carrito.length === 0) {
        // Si el carrito está vacío, muestra un mensaje
        carritoContainer.innerHTML = `<p class="carrito-vacio">El carrito está vacío.</p>`;
        localStorage.removeItem('carrito => ' + usuario);
    }
}
