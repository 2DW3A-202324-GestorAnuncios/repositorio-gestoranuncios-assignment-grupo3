<?php
    include("conexion.php");

    function eliminarFotoAnuncios($nombreArchivo) {
        $directorio_destino = 'img/anuncios/' . $nombreArchivo;
        if (file_exists($directorio_destino)) {
            unlink($directorio_destino); // Borra el archivo
        }

















    }

    $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
    $resultAnuncios = $conn->query($sqlAnuncios);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar_anuncio"])) {
        $id_anuncio = $_POST["validar_anuncio"];
        
        // Realiza una consulta SQL para actualizar el campo validado a 1
        $sqlValidarAnuncio = "UPDATE anuncio SET validado = '1' WHERE id_anuncio = :id_anuncio";
        
        $stmt = $conn->prepare($sqlValidarAnuncio);
        $stmt->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
        $stmt->execute();
        $resultAnuncios = $conn->query($sqlAnuncios);

            // Realiza una consulta SQL para actualizar el campo validado a 1
            $sqlValidarAnuncio = "UPDATE anuncio SET validado = '1' WHERE id_anuncio = :id_anuncio";





            $stmt = $conn->prepare($sqlValidarAnuncio);
            $stmt->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
            $stmt->execute();

            $resultAnuncios = $conn->query($sqlAnuncios);
        } else if (isset($_POST["eliminar_anuncio"])) {
            $id_anuncio = $_POST["eliminar_anuncio"];
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
                eliminarFotoAnuncios($sacarFoto['foto']); // Llama a la función eliminarFotoAnuncios
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_anuncio"])) {
        $id_anuncio = $_POST["eliminar_anuncio"];
        $sqlEliminarAnuncio = "DELETE FROM anuncio WHERE id_anuncio = :id_anuncio";
        $stmt = $conn->prepare($sqlEliminarAnuncio);
        $stmt->bindParam(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
        $stmt->execute();
        $resultAnuncios = $conn->query($sqlAnuncios);
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

    <section class="seccion-destacada" >
        <div class="seccion-titulo" >
            <h1 class="titulo-llamativo" >Validación de anuncios</h1>
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
                            echo '<button type="button" name="validar-anuncio" class="btn-validar" data-modal="modalValidarA_' . $row['id_anuncio'] . '">Validar</button>';
                            echo '<div id="modalValidarA_' . $row['id_anuncio'] . '" class="modalValidarA" style="display: none;">';
                                echo '<div class="modal-content">';
                                    echo '<p>¿Está seguro de validar el anuncio?</p>';
                                    echo '<button id="confirmar-si" name="validar_anuncio" value="' . $row['id_anuncio'] . '">Sí</button>';
                                    echo '<button type="button" class="confirmar-no">No</button>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class = "contenedor-anuncio">';
                                echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                                echo '<p>' . $row['descripcion'] . '</p>';
                                echo '<p class="precio">' . $row['precio'] . '€</p>';
                            echo '</div>';
                            echo '<button style="background-color: #57aa26" name="validar_anuncio" value="' . $row['id_anuncio'] . '">Validar</button>';
                            echo '<br>';
                            echo '<br>';
                            echo '<button style="background-color: red" name="eliminar_anuncio" value="' . $row['id_anuncio'] . '">Eliminar</button>';
                        echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    

    <section class="seccion-destacada">
        <div class="seccion-titulo" >
            <h1 class="titulo-llamativo" >Validación de Noticias</h1>
        </div>
        <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                        echo '<form method="POST" action="validar.php">'; // Reemplaza 'tu_script.php' por la URL correcta
                            echo '<div>';
                                echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                            echo '</div>';
                            echo '<div class="contenedor-anuncio">';
                                echo '<h1 style="color: black" class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                                echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                            echo '</div>';
                            echo '<button style="background-color: #57aa26;" name="validar_noticia" value="' . $row['id_noticia'] . '">Validar</button>';
                            echo '<br>';
                            echo '<br>';
                            echo '<button style="background-color: red;" name="eliminar_noticia" value="' . $row['id_noticia'] . '">Eliminar</button>';
                        echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>

    <?php
        include('footer.php');
    ?>
</body>
</html>
