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

    <div class="carrito-container">
        <h2>Carrito de Compra</h2>
        
        <?php
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                echo '<table>';
                    echo '<thead>';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th>Producto</th>';
                            echo '<th>Precio</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                        foreach ($_SESSION['carrito'] as $producto) {
                            echo '<tr>';
                                echo '<td>' . $producto['foto'] . '</td>';
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

            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $producto) {
                    $total += $producto['precio'];
                }
            }

            echo '<p>Total del carrito: ' . $total . '€</p>';
        ?>
    </div>

    <?php
        include('footer.php');
    ?>
</body>
</html>
