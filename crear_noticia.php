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
        $usuario = $_SESSION["usuarioLogin"];

        $repeticionPK = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nomNoticia = $_POST['titulo'];
            $descNoticia = $_POST['descripcion'];
            $catNoticia = $_POST['categoria'];
            $usuNoticia = $_SESSION["usuarioLogin"];
            $fotoNoticia = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];
            
            // Directorio de destino para la foto
            $directorio_destino = 'img/noticias/' . $fotoNoticia;
            
            // Mueve el archivo temporal al directorio de fotos
            if(empty($nomNoticia)){
                $mensaje_error = "Debes introducir un titulo de noticia.";
            }else if(empty($descNoticia)){
                $mensaje_error = "Debes introducir una descripcion de noticia.";
            }else if(empty($catNoticia)){
                $mensaje_error = "Debes seleccionar una categoria de noticia.";
            }else if (move_uploaded_file($foto_temp, $directorio_destino)) {
                // Inserta los datos a la tabla "noticia" con el nombre de la imagen en la base de datos
                $sql = "INSERT INTO noticia (foto, titulo, descripcion, categoria, nombre_usuario) VALUES ('$fotoNoticia','$nomNoticia','$descNoticia','$catNoticia','$usuNoticia')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje_exito = "Se ha creado la publicación";
            } else {
                $mensaje_error = "Debes introducir una foto.";
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
            <input type="text" id="titulo" name="titulo"
                value="<?php echo isset($_POST['titulo']) ? $_POST['titulo'] : ''; ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"
                rows="4"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="deportes"
                    <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'deportes') ? 'selected' : ''; ?>>
                    Deportes</option>
                <option value="economia"
                    <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'economia') ? 'selected' : ''; ?>>
                    Economía</option>
                <option value="arte"
                    <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'arte') ? 'selected' : ''; ?>>Arte
                </option>
                <option value="tiempo"
                    <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'tiempo') ? 'selected' : ''; ?>>
                    Tiempo</option>
            </select>
            <button type="submit">Crear Noticia</button>
        </form>
    </section>

    <?php
        include('footer.php');
    ?>
</body>

</html>