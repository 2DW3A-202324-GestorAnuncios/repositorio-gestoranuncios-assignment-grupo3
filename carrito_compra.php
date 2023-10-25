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
    
    <div class="carrito-container">
        <h2>Carrito de Compra</h2>
        <table id="carrito-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Producto</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        // Obtener los datos del carrito desde el Local Storage
        const usuario = "<?php echo $usuario; ?>";
        const carrito = JSON.parse(localStorage.getItem('carrito => ' + usuario));

        // Verificar si hay datos en el carrito
        if (carrito && carrito.length > 0) {
            const tableBody = document.querySelector("#carrito-table tbody");

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
        } else {
            // Si el carrito está vacío, muestra un mensaje
            const table = document.getElementById("carrito-table");
            table.innerHTML = `
                <p>El carrito está vacío.</p>
            `;
        }
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>
