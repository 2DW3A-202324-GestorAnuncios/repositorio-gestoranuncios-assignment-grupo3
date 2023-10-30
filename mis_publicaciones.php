<?php     
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();

    $nombre_usuario = $_SESSION['usuarioLogin'];

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1' AND nombre_usuario = :nombre_usuario";
    $stmtNoticias = $conn->prepare($sqlNoticias);
    $stmtNoticias->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
    $stmtNoticias->execute();

    $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '1' AND nombre_usuario = :nombre_usuario";
    $stmtAnuncios = $conn->prepare($sqlAnuncios);
    $stmtAnuncios->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
    $stmtAnuncios->execute();
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
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <section class="seccion-destacada">
        <div class="seccion-titulo">
            <h1 class="titulo-llamativo">Mis Publicaciones</h1>
        </div>
    </section>

    <div class="productos">
        <?php
            while ($row = $stmtAnuncios->fetch(PDO::FETCH_ASSOC)) {
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/anuncios/' . $row['foto'];
                echo '<div class="producto">';
                    echo '<div class="imagen-producto">';
                        echo '<a href="pagina_anuncio.php?id='.urlencode($row['id_anuncio']).'&nombre='.urlencode($row['nombre_anuncio']).'&foto='.urlencode($row['foto']).'&descripcion='.urlencode($row['descripcion']).'&precio='.urlencode($row['precio']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '"></a>';
                    echo '</div>';
                    echo '<div class = "contenedor-anuncio">';
                        echo '<h2>' . ucfirst($row['nombre_anuncio']) . '</h2>';
                        echo '<p>' . ucfirst($row['descripcion']) . '</p>';
                        echo '<p class="precio">' . $row['precio'] . '€</p>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
    
    <div class="productos">
        <?php
            while ($row = $stmtNoticias->fetch(PDO::FETCH_ASSOC)) {
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['titulo']);
                $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];
                echo '<div class="producto">';
                    echo '<div class="imagen-producto">';
                    echo '<a href="pagina_noticias.php?titulo='.urlencode($row['titulo']).'&foto='.urlencode($row['foto']).'&categoria='.urlencode($row['categoria']).'&descripcion='.urlencode($row['descripcion']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '" class="imagen-noticia3"></a>';
                    echo '</div>';
                    echo '<div class="contenedor-anuncio">';
                        echo '<h1 style="color: black" class="titulo-noticia3-h1">' . ucfirst($row['categoria']) . '</h1>';
                        echo '<h2 class="titulo-noticia3">' . ucfirst($row['titulo']) . '</h2>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
    </div>

    <?php
        include('footer.php');
    ?>
</body>
</html>