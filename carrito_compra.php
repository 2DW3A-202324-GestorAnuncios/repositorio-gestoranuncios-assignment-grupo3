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
        } else {
            document.getElementById('datos').innerText = 'No hay datos en LocalStorage.';
        }
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>
