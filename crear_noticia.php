<?php
include("conexion.php");

// Inicia la sesión en la página
session_start();
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
    <title>Crear Noticia - CIFP Txurdinaga</title>
</head>

<body>
    <?php
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }

        $mensaje_exito = '';
        $mensaje_error = '';
        $usuario = $_SESSION['usuarioLogin'];

        $repeticionPK = '';
        $nomNoticia = '';
        $descNoticia = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nomNoticia = $_POST['titulo'];
            $descNoticia = $_POST['descripcion'];
            $catNoticia = $_POST['categoria'];
            $usuNoticia = $_SESSION['usuarioLogin'];
            $fotoNoticia = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];

            // Directorio de destino para la foto
            $directorio_destino = 'img/noticias/' . $fotoNoticia;

            if (empty($nomNoticia)) {
                $mensaje_error = "Debes introducir el título de la noticia.";
            } else if (empty($descNoticia)) {
                $mensaje_error = "Debes introducir la descripción de la noticia.";
            } else if (empty($fotoNoticia)) {
                $mensaje_error = "Debes introducir una foto.";
            } else if (move_uploaded_file($foto_temp, $directorio_destino)) {
                // Inserta los datos a la tabla "noticia" con el nombre de la imagen en la base de datos
                $sql = "INSERT INTO noticia (foto, titulo, descripcion, categoria, nombre_usuario) VALUES ('$fotoNoticia','$nomNoticia','$descNoticia','$catNoticia','$usuNoticia')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje_exito = "Se ha creado la publicación";

                // Restablecer los campos a cadenas vacías después de un envío exitoso
                $nomNoticia = '';
                $descNoticia = '';
            } else {
                $mensaje_error = "Ocurrió un error al subir la foto.";
            }
        }
        
        if (!empty($mensaje_exito)) {
            echo '<div class="mensaje-exito">';
            echo '<p><strong>Éxito!</strong> ' . $mensaje_exito . '</p>';
            echo '</div>';
        } else if (!empty($mensaje_error)) {
            echo '<div class="mensaje-error">';
            echo '<p><strong>Error!</strong> ' . $mensaje_error . '</p>';
            echo '</div>';
        }
    ?>

    <section class="crear-noticia">
        <h1>Crear Noticia</h1>
        <form class="form-crear-noticia" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $nomNoticia; ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?php echo $descNoticia; ?></textarea>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="deportes">Deportes</option>
                <option value="economia">Economía</option>
                <option value="arte">Arte</option>
                <option value="tiempo">Tiempo</option>
            </select>
            <button type="submit">Crear Noticia</button>
        </form>
    </section>

    <?php
    include('footer.php');
    ?>

</body>

</html>