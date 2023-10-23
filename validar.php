<?php
include("conexion.php");

function eliminarFoto($nombreArchivo) {
    $directorio_destino = './img/anuncios/' . $nombreArchivo;

    if (file_exists($directorio_destino)) {
        unlink($directorio_destino); // Borra el archivo

    }
}

$sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
$resultNoticias = $conn->query($sqlNoticias);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar-noticia"])) {
    $id_noticia = $_POST["validar-noticia"];

    // Realiza una consulta SQL para actualizar el campo validado a 1
    $sqlValidarNoticia = "UPDATE noticia SET validado = '1' WHERE id_noticia = :id_noticia";

    $stmt = $conn->prepare($sqlValidarNoticia);
    $stmt->bindValue(':id_noticia', $id_noticia, PDO::PARAM_INT);
    $stmt->execute();
    $resultNoticias = $conn->query($sqlNoticias);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar-noticia"])) {
    $id_noticia = $_POST["eliminar-noticia"];
    $sqlEliminarNoticia = "DELETE FROM noticia WHERE id_noticia = :id_noticia";
    $stmt = $conn->prepare($sqlEliminarNoticia);
    $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
    $stmt->execute();
    $resultNoticias = $conn->query($sqlNoticias);
}

$sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
$resultAnuncios = $conn->query($sqlAnuncios);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar-anuncio"])) {
    $id_anuncio = $_POST["validar-anuncio"];

    // Realiza una consulta SQL para actualizar el campo validado a 1
    $sqlValidarAnuncio = "UPDATE anuncio SET validado = '1' WHERE id_anuncio = :id_anuncio";

    $stmt = $conn->prepare($sqlValidarAnuncio);
    $stmt->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
    $stmt->execute();
    $resultAnuncios = $conn->query($sqlAnuncios);

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar-anuncio"])) {
    $id_anuncio = $_POST["eliminar-anuncio"];
    $sqlFoto = "SELECT foto FROM anuncio WHERE id_anuncio = :id_anuncio";
    $stmtFoto = $conn->prepare($sqlFoto);
    $stmtFoto->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
    $stmtFoto->execute();
    $sacarFoto = $stmtFoto->fetch();

    $sqlEliminarAnuncio = "DELETE FROM anuncio WHERE id_anuncio = :id_anuncio";
    $stmt = $conn->prepare($sqlEliminarAnuncio);
    $stmt->bindParam(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
    $stmt->execute();

    $resultAnuncios = $conn->query($sqlAnuncios);

    // Obtener el nombre del archivo de la base de datos

    // Verificar si la consulta fue exitosa
    if ($sacarFoto && isset($sacarFoto['foto'])) {
        eliminarFoto($sacarFoto['foto']); // Llama a la función eliminarFoto
    }
}
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

    <section class="seccion-destacada">
        <div class="seccion-titulo">
            <h1 class="titulo-llamativo">Validación de anuncios</h1>
        </div>
        <div class="productos">
            <?php
            while ($row = $resultAnuncios->fetch(PDO::FETCH_ASSOC)) {
                $nombre_anuncio = $row['nombre_anuncio'];
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                echo '<form class="producto" method="POST" action="validar.php">';
                    echo '<div class="imagen-producto">';
                        echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '</div>';
                    echo '<div class="contenedor-anuncio">';
                        echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p class="precio">' . $row['precio'] . '€</p>';
                    echo '</div>';
                    echo '<div class="btn-container">';
                        echo '<button name="validar-anuncio" value="' . $row['id_anuncio'] . '">Validar</button>';
                        echo '<button name="eliminar-anuncio" value="' . $row['id_anuncio'] . '">Eliminar</button>';
                    echo'</div>';
                echo '</form>';
            }
            ?>
        </div>
    </section>
    <br>
    <br>
    <section class="seccion-destacada">
        <div class="seccion-titulo" >
            <h1 class="titulo-llamativo">Validación de Noticias</h1>
        </div>
        <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<form class="producto" method="POST" action="validar.php">'; // Reemplaza 'tu_script.php' por la URL correcta
                        echo '<div class="imagen-producto">';
                            echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                        echo '</div>';
                        echo '<div class="contenedor-anuncio">';
                            echo '<h1 style="color: black" class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                            echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                        echo '</div>';
                        echo '<div class="btn-container">';
                            echo '<button name="validar-noticia" id="confirmacionN" value="' . $row['id_noticia'] . '">Validar</button>';
                            echo '<button name="eliminar-noticia" value="' . $row['id_noticia'] . '">Eliminar</button>';
                        echo '</div>';
                    echo '</form>';
                }
            ?>
        </div>
    </section>

    <?php
        include('footer.php');
    ?>
</body>
</html>
<!-- 
                    echo '<form class="producto" method="POST" action="validar.php">'; // Reemplaza 'tu_script.php' por la URL correcta
                        echo '<div class="imagen-producto">';
                            echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                        echo '</div>';
                        echo '<div class="contenedor-anuncio">';
                            echo '<h1 style="color: black" class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                            echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                        echo '</div>';
                        echo '<div class="btn-container">';
                            echo '<button type="button" name="validar-noticia" id="confirmacionN">Validar</button>';
                            echo '<div id="confirmar-cierre" class="modalValidarN" style="display: none;">';
                                echo '<div class="modal-content" display="none">';
                                    echo '<p>¿Esta seguro de validar la noticia?</p>';
                                    echo '<button id="confirmar-si" name="validar_noticia" value="' . $row['id_noticia'] . '">Sí</button>';
                                    echo '<button type="button" id="confirmar-no-validarN">No</button>';
                                echo '</div>';
                            echo '</div>';
                            echo '<button type="button" name="eliminar-noticia" id="confirmacionEliminarN">Eliminar</button>';
                            echo '<div id="confirmar-cierre" class="modalEliminarN" style="display: none;">';
                                echo '<div class="modal-content" display="none">';
                                    echo '<p>¿Esta seguro de eliminar la noticia?</p>';
                                    echo '<button id="confirmar-si" name="eliminar_noticia" value="' . $row['id_noticia'] . '">Sí</button>';
                                    echo '<button type="button" id="confirmar-no-eliminarN">No</button>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
            


                    $nombre_anuncio = $row['nombre_anuncio'];
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                    echo '<form class="producto" method="POST" action="validar.php">';
                        echo '<div class="imagen-producto">';
                            echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                        echo '</div>';
                        echo '<div class="contenedor-anuncio">';
                            echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                            echo '<p>' . $row['descripcion'] . '</p>';
                            echo '<p class="precio">' . $row['precio'] . '€</p>';
                        echo '</div>';
                        echo '<div class="btn-container">';
                            echo '<button type="button" name="validar-anuncio" id="confirmacionA">Validar</button>';
                            echo '<div id="confirmar-cierre" class="modalValidarA" style="display: none;">';
                                echo '<div class="modal-content" display="none">';
                                    echo '<p>¿Esta seguro de validar el anuncio?</p>';
                                    echo '<button id="confirmar-si" name="validar_anuncio" value="' . $row['id_anuncio'] . '">Sí</button>';
                                    echo '<button type="button" id="confirmar-no-validarA">No</button>';
                                echo '</div>';
                            echo '</div>';
                            echo '<button type="button" name="eliminar-anuncio" id="confirmacionEliminarA">Eliminar</button>';
                            echo '<div id="confirmar-cierre" class="modalEliminarA" style="display: none;">';
                                echo '<div class="modal-content" display="none">';
                                    echo '<p>¿Esta seguro de eliminar el anuncio?</p>';
                                    echo '<button id="confirmar-si" name="eliminar_anuncio" value="' . $row['id_anuncio'] . '">Sí</button>';
                                    echo '<button type ="button" id="confirmar-no-eliminarA">No</button>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
                
                 -->