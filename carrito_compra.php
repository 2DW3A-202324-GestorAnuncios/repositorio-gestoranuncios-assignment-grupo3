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
        
        <?php
            echo '
            <script>
                localStorage.getItem("carrito");
            </script>';

            // Obtener el carrito del Local Storage y decodificarlo
            $carrito = json_decode("carrito", true);

            if (!empty($carrito)) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th></th>';
                echo '<th>Producto</th>';
                echo '<th>Precio</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($carrito as $producto) {
                    echo '<tr>';
                    echo '<td><img src="img/anuncios/' . $producto['foto'] . '" alt="' . $producto['nombre'] . '"></td>';
                    echo '<td>' . $producto['nombre'] . '</td>';
                    echo '<td>' . $producto['precio'] . '€</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>El carrito está vacío.</p>';
            }
        ?>

        <?php
            // Calcular el total del carrito
            $total = 0;

            if (!empty($carrito)) {
                foreach ($carrito as $producto) {
                    $total += $producto['precio'];
                }
            }

            echo '<p>Total del carrito: ' . $total . '€</p>';
        ?>
    </div>

    <div id="datos"></div>

    <script>
        // Obtener los datos de localStorage
        const datosLocalStorage = localStorage.getItem('carrito');

        // Verificar si hay datos en localStorage
        if (datosLocalStorage) {
            // Crear un elemento HTML para mostrar los datos
            const divDatos = document.getElementById('datos');
            divDatos.textContent = datosLocalStorage;
            // Iterar a través de los productos en el carrito y agregarlos a la tabla
            carrito.forEach(producto => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td id="celdaImg"><img src="img/anuncios/${producto.foto}" alt="${producto.nombre}"></td>
                    <td>${producto.nombre}</td>
                    <td>${producto.precio}€</td>
                `;
                tableBody.appendChild(row);
            });
            tableBody.append(localStorage.getItem('carrito => ' + usuario));
        } else {
            // Si el carrito está vacío, muestra un mensaje
            const table = document.getElementById("carrito-table");
            table.innerHTML = `
                <p>El carrito está vacío.</p>
            `;
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