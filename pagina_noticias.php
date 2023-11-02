<?php
    // Inicia la sesión en la página
    include ("conexion.php");

    // Iniciamos la sesion 
    session_start();

    // Recogemos los datos y los metemos en las variables 
    $categoria = ucfirst($_GET['categoria']);
    $titulo = ucfirst($_GET['titulo']);
    $foto = $_GET['foto'];
    $descripcion = ucfirst($_GET['descripcion']);
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
    <script src="script.js"></script>
    <title><?php echo $titulo ?>- CIFP Txurdinaga</title>
</head>
<body>
    <!-- Cargamos el header dependiendo de si la sesion esta iniciada utilizando php -->
    <?php
        // Comprobamos que la session este iniciada y que no este vacia
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <section class="ver-noticia">
        <div class="ver-noticia-img">
            <!-- Cargamos La categoria y la foto de la noticia especifica para mostrarla -->
            <?php 
                echo '<h3>' . $categoria . '</h3>';
                echo '<img src="img/noticias/' . $foto . '" height="100%" width="100%">';
            ?>
        </div>
        
        <div class="ver-noticia-contenido">
            <!-- Cargamos el titulo y la descripcion -->
            <?php
                echo '<h1>' . $titulo . '</h1>';
                echo '<p>' . $descripcion . '</p>';
            ?>
        </div>
    </section>
    
    <!-- Cargamos el footer con php -->
    <?php
        include('footer.php');
    ?>    
</body>
</html>
