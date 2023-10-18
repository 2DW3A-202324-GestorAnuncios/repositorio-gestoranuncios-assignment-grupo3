<?php
    include("conexion.php");

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
    $resultNoticias = $conn->query($sqlNoticias);

    $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
    $resultAnuncios = $conn->query($sqlAnuncios);
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
    <title>Validación - CIFP Txurdinaga</title>
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
    ?>
    <section class="seccion-destacada" >
        <div class="seccion-titulo" >
        <h1 class="titulo-llamativo" >Validación de anuncios</h1>
    </div>
    <div class="productos">
        <?php
            while ($row = $resultAnuncios->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="producto">';
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                    echo '<div class = "imagen-producto">';
                        echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '</div>';
                    echo '<div class = "contenedor-anuncio">';
                        echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p class="precio">' . $row['precio'] . '€</p>';
                    echo '</div>';
                    echo '<button style ="background-color: #57aa26">validar</button>';
                    echo '<br>';
                    echo '<button style ="background-color: red">eliminar</button>';
                echo '</div>';
            }
        ?>
    </div>
    </section>
    <br>
    <br>
    <section class="seccion-destacada" >
    <div class="seccion-titulo" >
        <h1 class="titulo-llamativo" >Validación de noticias</h1>
    </div>
    <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                        echo '<div class = "imagen-producto">';
                            echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                        echo '</div>';
                            echo '<div class = "contenedor-anuncio">';
                            echo '<h1 class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                            echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                            echo '<button style ="background-color: #57aa26" >validar</button>';
                            echo '<br>';
                            echo '<button style ="background-color: red">eliminar</button>';
                        echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    <?php include('footer.php'); ?>
</body>
</html>