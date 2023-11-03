<?php
    // Inicia la sesión en la página
    session_start();
?>

<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <script src="script.js"></script>
    <title>Carrito de Compra - CIFP Txurdinaga</title>
</head>
<body onload="actualizarCarrito()">
    <?php
        include('header_sesion.php');
    ?>
    
    <div class="carrito-container">
        <h2>Carrito de Compra</h2>
        <div id="carrito-items"></div>
        <p class="subtotal-carrito">Subtotal (<span id="total-productos">0 productos</span>): <span id="total-precio">0 €</span></p>
    </div>

    <?php
        include('footer.php');
    ?>
</body>
</html>
