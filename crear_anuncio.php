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
    <title>Crear Anuncio - CIFP Txurdinaga</title>
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //coje los elementos del formulario
            $nomAnuncio = $_POST['titulo'];
            $descAnuncio = $_POST['descripcion'];
            $precAnuncio = $_POST['precio'];
            $usuAnuncio = $_SESSION['usuarioLogin'];
            $fotoAnuncio = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];

            $directorio_destino = 'img/anuncios/' . $fotoAnuncio;

            if(empty($nomAnuncio) && empty($descAnuncio)){
                $mensaje_error = "Debes introducir el titulo y la descripcion del anuncio.";
            }else if(empty($nomAnuncio)){
                $mensaje_error = "Debes introducir un titulo del anuncio.";
            }else if(empty($descAnuncio)){
                $mensaje_error = "Debes introducir una descripcion del anuncio.";
            }else if (!empty($fotoAnuncio)) {
                if (move_uploaded_file($foto_temp, $directorio_destino)) {
                    // Inserta los datos a la tabla "Anuncio" con el nombre de la imagen en la base de datos
                    $sql = "INSERT INTO anuncio (nombre_anuncio, precio, descripcion, foto, nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$fotoAnuncio','$usuAnuncio')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    $mensaje_exito = "Se ha creado la publicación";
                }
            } else {
                $sql = "INSERT INTO anuncio (nombre_anuncio, precio, descripcion, nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$usuAnuncio')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

                $mensaje_exito = "Se ha creado la publicación";
            }
        }

        if (!empty($mensaje_exito)) {
            echo '<div class="mensaje-exito">';
                echo '<p><strong>Éxito!</strong> ' . $mensaje_exito . '</p>';
            echo '</div>';
        } else if (!empty($mensaje_error)) {
            echo '<div class="mensaje-error">';
                echo '<p><strong>Error!</strong> ' . $mensaje_error .'</p>';
            echo '</div>';
        }
    ?>

    <section class="crear-anuncio">
        <h1>Crear un Anuncio</h1>
        <div class="form-crear-anuncio">
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">

                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" placeholder="0" min="0">
                <button type="submit">Crear Anuncio</button>
            </form>
        </div>
    </section>

    <?php
        include('footer.php');
    ?>
</body>

</html>