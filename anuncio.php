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
    <title>Anuncios - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        include("header.php");
    ?>

    <section>
        <div class="productos">
        <div class="producto">
            <img src="producto1.jpg" alt="Producto 1">
            <h2>Nombre del Producto 1</h2>
            <p>Descripción del Producto 1.</p>
            <p>Precio: $XX.XX</p>
            <button>Comprar</button>
        </div>
        <div class="producto">
            <img src="img/producto2.jpg" alt="Producto 2">
            <h2>Nombre del Producto 2</h2>
            <p>Descripción del Producto 2.</p>
            <p>Precio: $XX.XX</p>
            <button>Comprar</button>
        </div>
        </div>
    </section>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
