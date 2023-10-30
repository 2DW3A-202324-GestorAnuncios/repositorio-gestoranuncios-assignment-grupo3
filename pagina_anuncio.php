<?php
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();

    $nombre = ucfirst($_GET['nombre']);
    $foto = $_GET['foto'];
    $descripcion = ucfirst($_GET['descripcion']);
    $precio = $_GET['precio'];
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
    <title><?php echo $nombre ?> - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <section class="ver-anuncio">
        <div class="ver-anuncio-img">
            <?php 
                echo '<img src="img/anuncios/' . $foto . '" height="100%" width="100%">';
            ?>
        </div>
        <div class="ver-anuncio-contenido">
            <?php
                echo '<h1>' . $nombre . '</h1>';
                echo '<h3>' . $descripcion . '</h3>';
                echo '<h2>Precio: ' . $precio . '€</h2>';
                echo '<input class="boton" type="button" value="COMPRAR">';
            ?>
        </div>
    </section>

    <script>
        //para prevenir el reenvio del formulario al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }  
    </script>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
