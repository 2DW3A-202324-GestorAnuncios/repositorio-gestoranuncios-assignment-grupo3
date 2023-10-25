<?php     
    include("conexion.php");
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
    <title>Mis Publicaciones - CIFP Txurdinaga</title>
</head>
<body>
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
    echo '<section class="seccion-destacada">
            <div class="seccion-titulo">
                <h1 class="titulo-llamativo">Publicaciones de '. $_SESSION['usuario'] .'</h1>
            </div>
        </section>';

    $nombre_usuario = $_SESSION['usuario'];


        $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1' AND nombre_usuario = :nombre_usuario";
        $stmtNoticias = $conn->prepare($sqlNoticias);
        $stmtNoticias->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmtNoticias->execute();

        $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '1' AND nombre_usuario = :nombre_usuario";
        $stmtAnuncios = $conn->prepare($sqlAnuncios);
        $stmtAnuncios->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmtAnuncios->execute();

    ?>
    <div class="productos">
            <?php
                while ($row = $stmtAnuncios->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                        $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                        echo '<form method="POST" action="validar.php">';
                            echo '<div class="imagen-validar">';
                                echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                            echo '</div>';
                            echo '<div class = "contenedor-anuncio">';
                                echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                                echo '<p>' . $row['descripcion'] . '</p>';
                                echo '<p class="precio">' . $row['precio'] . '€</p>';
                            echo '</div>';
                        echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
        <br>
        <br>
        <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $stmtNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                        echo '<form method="POST" action="validar.php">'; // Reemplaza 'tu_script.php' por la URL correcta
                            echo '<div>';
                                echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '"class="imagen-noticia3">';
                            echo '</div>';
                            echo '<div class="contenedor-anuncio">';
                                echo '<h1 style="color: black" class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                                echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                            echo '</div>';
                        echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>


    <?php
        include('footer.php');
    ?>
</body>
</html>