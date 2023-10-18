<?php
    include("conexion.php");

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
    $resultNoticias = $conn->query($sqlNoticias);
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar_noticia"])) {
        $noticia_id = $_POST["validar_noticia"];
        
        // Realiza una consulta SQL para actualizar el campo validado a 1
        $sqlValidarNoticia = "UPDATE noticia SET validado = '1' WHERE id_noticia = :noticia_id";
        
        $stmt = $conn->prepare($sqlValidarNoticia);
        $stmt->bindValue(':noticia_id', $noticia_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirige o muestra un mensaje de éxito
        
        // Luego, ejecuta la consulta para obtener las noticias no validadas
        $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
        $resultNoticias = $conn->query($sqlNoticias);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_noticia"])) {
        $noticia_id = $_POST["eliminar_noticia"];
        $sqlEliminarNoticia = "DELETE FROM noticia WHERE id_noticia = :noticia_id";
        $stmt = $conn->prepare($sqlEliminarNoticia);
        $stmt->bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
        $stmt->execute();
        // Redirige o muestra un mensaje de éxito

        $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
        $resultNoticias = $conn->query($sqlNoticias);
    }

    $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
    $resultAnuncios = $conn->query($sqlAnuncios);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["validar_anuncio"])) {
        $anuncio_id = $_POST["validar_anuncio"];
        
        // Realiza una consulta SQL para actualizar el campo validado a 1
        $sqlValidarAnuncio = "UPDATE anuncio SET validado = '1' WHERE id_anuncio = :anuncio_id";
        
        $stmt = $conn->prepare($sqlValidarAnuncio);
        $stmt->bindValue(':anuncio_id', $anuncio_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirige o muestra un mensaje de éxito
        
        // Luego, ejecuta la consulta para obtener las noticias no validadas
        $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
        $resultAnuncios = $conn->query($sqlAnuncios);

    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_anuncio"])) {
        $anuncio_id = $_POST["eliminar_anuncio"];
        $sqlEliminarAnuncio = "DELETE FROM anuncio WHERE id_anuncio = :anuncio_id";
        $stmt = $conn->prepare($sqlEliminarAnuncio);
        $stmt->bindParam(':anuncio_id', $anuncio_id, PDO::PARAM_INT);
        $stmt->execute();
        // Redirige o muestra un mensaje de éxito

        $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
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
                    echo '<div class="producto">';
                        $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                        echo '<form method="POST" action="validar.php">';
                            echo '<div class = "imagen-validar">';
                                echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                            echo '</div>';
                            echo '<div class = "contenedor-anuncio">';
                                echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                                echo '<p>' . $row['descripcion'] . '</p>';
                                echo '<p class="precio">' . $row['precio'] . '€</p>';
                            echo '</div>';
                            echo '<button style="background-color: #57aa26" name="validar_anuncio" value="' . $row['id_anuncio'] . '">Validar</button>';
                            echo '<br>';
                            echo '<br>';
                            echo '<button style="background-color: red" name="eliminar_anuncio" value="' . $row['id_anuncio'] . ' id = "btn_eliminar_anuncio">Eliminar</button>';
                            echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    <br>
    <br>
    <section class="seccion-destacada">
        <div class="seccion-titulo" >
            <h1 class="titulo-llamativo" >Validación de Noticias</h1>
        </div>
        <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                        echo '<form method="POST" action="validar.php">'; // Reemplaza 'tu_script.php' por la URL correcta
                            echo '<div class="imagen-validar">';
                                echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                            echo '</div>';
                            echo '<div class="contenedor-anuncio">';
                                echo '<h1 style="color: black" class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                                echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                                echo '<button style="background-color: #57aa26" name="validar_noticia" value="' . $row['id_noticia'] . '">Validar</button>';
                                echo '<br>';
                                echo '<br>';
                                echo '<button style="background-color: red" name="eliminar_noticia" value="' . $row['id_noticia'] . '">Eliminar</button>';
                            echo '</div>';
                        echo '</form>';
                    echo '</div>';
                }
            ?>
            <div id="confirmar-cierre" class="modal" style="display: none;">
            <div class="modal-content">
                <p>¿Estás seguro de que deseas cerrar la sesión?</p>
                <button id="confirmar-si">Sí</button>
                <button id="confirmar-no">No</button>
            </div>
        </div>

        </div>
    </section>
    <script>
        // JavaScript para cambiar entre el modo de visualización y el modo de edición
        const btn_eliminar_anuncio = document.getElementById('btn_eliminar_anuncio');
        const modal = document.querySelector('.modal');
        const confirmarSiBtn = document.getElementById('confirmar-si');
        const confirmarNoBtn = document.getElementById('confirmar-no');
        const btn_eliminar_anuncio_value = Document.getElementById('btn_eliminar_anuncio').value;

        btn_eliminar_anuncio.addEventListener('click', () => {
            // Muestra el desplegable
            modal.style.display = 'block'
            document.body.classList.add('no-scroll'); // Agrega la clase para desactivar el scroll
        });

        confirmarSiBtn.addEventListener('click', () => {
            // Aquí debes agregar la lógica para cerrar la sesión
            // Puedes usar una redirección a la página de cierre de sesión
            btn_eliminar_anuncio_value.submit();// Esto es un ejemplo, asegúrate de ajustar la URL a tu configuración
        });

        confirmarNoBtn.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll'); // Quita la clase para restaurar el scroll
        });
    </script>
    <?php
        include('footer.php');
    ?>
</body>
</html>
