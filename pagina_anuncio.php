<?php
    // Inicia la sesión en la página
    session_start();

    if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
        include('header_sesion.php');
        // Comprobar si el usuario es administrador
        $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
    } else {
        include('header_no_sesion.php');
    }

    include('conexion.php');

    $_POST['foto'] = $_SESSION['foto']; 

    $_POST['nombre'] = $_SESSION['nombre']; 

    $_POST['descripcion'] = $_SESSION['descripcion']; 
            
    $_POST['precio'] = $_SESSION['precio'];
  
    
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
        <title><?php echo $_POST['nombre'] ?> - CIFP Txurdinaga</title>
    </head>
    <body>
        <section>
            <div>
                <?php 
                    echo '<img src="img/anuncios/' . $_POST['foto'] . '">';
                ?>
            </div>
            
        </section>
    </body>
    <?php
        include('footer.php');
    ?>
</html>