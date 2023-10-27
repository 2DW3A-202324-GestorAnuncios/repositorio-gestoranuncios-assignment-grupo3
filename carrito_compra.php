<!DOCTYPE html>
<html lang="es-Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Carrito de Compra - CIFP Txurdinaga</title>
</head>

<body>
    <?php
        // Inicia la sesión en la página
        session_start();

        $usuario = $_SESSION['usuario'];

        include('header_sesion.php');
    ?>

    <script>
    localStorage.getItem("carrito");
    </script>

    <div class="carrito-container">
        <h2>Carrito de Compra</h2>
        <div id="carrito-items"></div>
    </div>

    <div id="datos"></div>

    <script>
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

        // Recrear la vista del carrito con los productos actualizados
        carrito.forEach(producto => {
            const itemContainer = document.createElement("div");
            itemContainer.classList.add("carrito-item");

            const fotoCarrito = document.createElement("div");
            fotoCarrito.classList.add("foto-carrito");
            fotoCarrito.innerHTML = `<img src="img/anuncios/${producto.foto}" alt="${producto.nombre}">`;

            const carritoContent = document.createElement("div");
            carritoContent.classList.add("carrito-content");
            carritoContent.innerHTML = `
                    <p class="producto-nombre">${producto.nombre}</p>
                    <p class="producto-descripcion">${producto.descripcion}</p>
                    <p class="producto-precio">${producto.precio}€</p>
                `;

            const eliminarButton = document.createElement("button");
            eliminarButton.classList.add("eliminar-button");
            eliminarButton.setAttribute("data-id", producto.id);
            eliminarButton.innerHTML = '<img src="img/papelera.png" alt="Eliminar">';
            eliminarButton.addEventListener('click', () => eliminarProducto(producto.id));

            itemContainer.appendChild(fotoCarrito);
            itemContainer.appendChild(carritoContent);
            itemContainer.appendChild(eliminarButton);

            carritoContainer.appendChild(itemContainer);

        });

        if (carrito.length === 0) {
            // Si el carrito está vacío, muestra un mensaje
            carritoContainer.innerHTML = `<p class="carrito-vacio">El carrito está vacío.</p>`;
            localStorage.removeItem('carrito => ' + usuario);
        }
    }

    // Cargar el carrito inicialmente
    actualizarCarrito();
    </script>

    <?php
        include('footer.php');
    ?>
</body>

</html>