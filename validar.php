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
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_anuncio"])) {
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
            eliminarFotoAnuncios($sacarFoto['foto']); // Llama a la función eliminarFoto
        }
    }
    
    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
    $resultNoticias = $conn->query($sqlNoticias);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar_noticia"])) {
        $id_noticia = $_POST["validar_noticia"];

        // Realiza una consulta SQL para actualizar el campo validado a 1
        $sqlValidarNoticia = "UPDATE noticia SET validado = '1' WHERE id_noticia = :id_noticia";

        $stmt = $conn->prepare($sqlValidarNoticia);
        $stmt->bindValue(':id_noticia', $id_noticia, PDO::PARAM_INT);
        $stmt->execute();

        $resultNoticias = $conn->query($sqlNoticias);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_noticia"])) {
        $id_noticia = $_POST["eliminar_noticia"];
        $sqlEliminarNoticia = "DELETE FROM noticia WHERE id_noticia = :id_noticia";
        $stmt = $conn->prepare($sqlEliminarNoticia);
        $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
        $stmt->execute();

        $resultNoticias = $conn->query($sqlNoticias);
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
                }
            ?>
        </div>
    </section>
    
    <section class="seccion-destacada">
        <div class="seccion-titulo">
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
                }
            ?>
        </div>
    </section>
    <script>
        // JavaScript para cambiar entre el modo de visualización y el modo de edición
        const confirmacionA = document.getElementById('confirmacionA');
        const confirmacionEliminarA = document.getElementById('confirmacionEliminarA');
        const confirmacionN = document.getElementById('confirmacionN');
        const confirmacionEliminarN = document.getElementById('confirmacionEliminarN');
        const modalValidarA = document.querySelector('.modalValidarA');
        const modalEliminarA = document.querySelector('.modalEliminarA');
        const modalValidarN = document.querySelector('.modalValidarN');
        const modalEliminarN = document.querySelector('.modalEliminarN');
        const confirmarSiBtn = document.getElementById('confirmar-si');
        const confirmarNoBtnValidarA = document.getElementById('confirmar-no-validarA');
        const confirmarNoBtnEliminarA = document.getElementById('confirmar-no-eliminarA');
        const confirmarNoBtnValidarN = document.getElementById('confirmar-no-validarN');
        const confirmarNoBtnEliminarN = document.getElementById('confirmar-no-eliminarN');

        confirmacionA.addEventListener('click', () => {
            // Muestra el desplegable
            modalValidarA.style.display = 'block';
            document.body.classList.add('no-scroll');
        });

        confirmacionN.addEventListener('click', () => {
            // Muestra el desplegable
            modalValidarN.style.display = 'block';
            document.body.classList.add('no-scroll');
        });

        confirmacionEliminarA.addEventListener('click', () => {
            // Muestra el desplegable
            modalEliminarA.style.display = 'block';
            document.body.classList.add('no-scroll');
        });

        confirmacionEliminarN.addEventListener('click', () => {
            // Muestra el desplegable
            modalEliminarN.style.display = 'block';
            document.body.classList.add('no-scroll');
        });

        confirmarSiBtn.addEventListener('click', () => {
            // Aquí debes agregar la lógica para cerrar la sesión
            // Puedes usar una redirección a la página de cierre de sesión
            window.location.href = 'validar.php'; // Esto es un ejemplo, asegúrate de ajustar la URL a tu configuración
        });

        confirmarNoBtnValidarA.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modalValidarA.style.display = 'none';
            document.body.classList.remove('no-scroll');
        });
        
        confirmarNoBtnValidarN.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modalValidarN.style.display = 'none';
            document.body.classList.remove('no-scroll');
        });

        confirmarNoBtnEliminarA.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modalEliminarA.style.display = 'none';
            document.body.classList.remove('no-scroll');
        });
        
        confirmarNoBtnEliminarN.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modalEliminarN.style.display = 'none';
            document.body.classList.remove('no-scroll');
        });
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>
