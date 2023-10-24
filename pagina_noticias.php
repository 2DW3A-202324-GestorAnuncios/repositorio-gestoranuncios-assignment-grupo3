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

    

    $categoria=$_GET['categoria'];
    $titulo=$_GET['titulo'];
    $foto=$_GET['foto'];

    $sql = "SELECT descripcion FROM noticia where titulo = '".$titulo."'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    
    
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
        <title><?php echo $titulo ?>- CIFP Txurdinaga</title>
    </head>
   
    <body>
        <br><br>
        <section class="ver-noticia">
            <div class="ver-noticia-img">
                <?php 
                    echo '<h3>' . $categoria . '</h3>';
                    echo '<img src="img/noticias/' . $foto . '" height="100%" width="100%">';

                ?>
            </div>
            
            <div class="ver-noticia-contenido">
                <?php
                    echo '<h1>' . $titulo . '</h1>';
                    echo '<h3>' . $row . '</h3>';
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