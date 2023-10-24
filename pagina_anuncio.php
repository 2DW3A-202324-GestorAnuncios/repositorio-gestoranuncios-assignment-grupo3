<?php
    // Inicia la sesión en la página
    include("conexion.php");

    session_start();

        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
            // Comprobar si el usuario es administrador
            $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
        } else {
            include('header_no_sesion.php');
        }

    $nombre=$_GET['nombre'];
    $foto=$_GET['foto'];
    $descripcion=$_GET['descripcion'];
    $precio=$_GET['precio'];
?>
<!DOCTYPE html>
<html lang="es-Es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
        <link rel="stylesheet" href="hojaEstilos/fuentes.css">
        <link rel="stylesheet" href="hojaEstilos/estilos.css?v=<?php echo time(); ?>">
        <link rel="shortcut icon" href="img/favicon.png">
        <title><?php echo $nombre ?> - CIFP Txurdinaga</title>
    </head>
    <body><br><br>
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
    </body>
    <?php
        include('footer.php');
    ?>
    <script>
        //para prevenir el reenvio del formulario al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }  
    </script>
</html>





