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
        include("conexion.php");
        // Inicia la sesión en la página
        session_start();

        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
            // Comprobar si el usuario es administrador
            $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
        } else {
            include('header_no_sesion.php');
        }
        
        $mensaje_exito = '';
        $mensaje_error = '';
        $usuario = $_SESSION["usuario"];

        $repeticionPK = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = mysqli_connect("localhost", "root", "", "gestor_anuncios");
            
            // Comprueba conexión
            if($conn === false){
                die("ERROR: No se ha podido conectar. " . mysqli_connect_error());
            }
            
            $nomNoticia = $_POST['titulo'];
            $descNoticia = $_POST['descripcion'];
            $catNoticia = $_POST['categoria'];
            $usuNoticia = $_SESSION["usuario"];
            $fotoNoticia = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];
            
            // Directorio de destino para la foto
            $directorio_destino = 'img/noticias/' . $fotoNoticia;
            
            // Mueve el archivo temporal al directorio de fotos
            if (move_uploaded_file($foto_temp, $directorio_destino)) {
                // Inserta los datos a la tabla "noticia" con el nombre de la imagen en la base de datos
                mysqli_query($conn, "INSERT INTO noticia (foto, titulo, descripcion, categoria, nombre_usuario) VALUES ('$fotoNoticia','$nomNoticia','$descNoticia','$catNoticia','$usuNoticia')");
                $mensaje_exito = "Se ha creado la publicación";
            } else {
                $mensaje_error = "Error al subir la foto.";
            }
            
            // Cierra conexión
            mysqli_close($conn);  
        }

        if (!empty($mensaje_exito)) {
            echo '<div class="mensaje-exito">';
                echo '<p><strong>Éxito!</strong> ' . $mensaje_exito . '</p>';
            echo '</div>';
        } elseif (!empty($mensaje_error)) {
            echo '<div class="mensaje-error">';
                echo '<p><strong>Error!</strong> ' . $mensaje_error . '</p>';
            echo '</div>';
        }
    ?>

    <main>
        <section class="crear-noticia">
            <h1>Crear Noticia</h1>
            <form class="form-crear-noticia" action="#" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" ></textarea>

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
    </main>

    <?php
        include('footer.php');
    ?>
</body>
</html>
