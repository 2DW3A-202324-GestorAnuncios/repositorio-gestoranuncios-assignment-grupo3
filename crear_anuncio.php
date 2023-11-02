<?php
    // Incluimos la conexion a la base de datos
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
    <!-- Cargamos el header dependiendo de si la sesion esta iniciada utilizando php -->
    <?php
        // Comprobamos que la session este iniciada y que no este vacia
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }

        // Generamos variables de mensajes y datos vacios para poder darles valores despues
        $mensaje_exito = '';
        $mensaje_error = '';
        $usuario = $_SESSION["usuarioLogin"];

        $nomAnuncio = '';
        $descAnuncio = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoje los elementos del formulario
            $nomAnuncio = $_POST['titulo'];
            $descAnuncio = $_POST['descripcion'];
            $precAnuncio = $_POST['precio'];
            $usuAnuncio = $_SESSION['usuarioLogin'];
            $fotoAnuncio = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];

            

            $directorio_destino = 'img/anuncios/' . $fotoAnuncio;

            // Comprobamos que los campos no esten vacios para poder subirlo a la base de datos
            if (empty($nomAnuncio) && empty($descAnuncio)) {
                $mensaje_error = "Debes introducir el título y la descripción del anuncio.";
            } else if (empty($nomAnuncio)) {
                $mensaje_error = "Debes introducir un título del anuncio.";
            } else if (empty($descAnuncio)) {
                $mensaje_error = "Debes introducir una descripción del anuncio.";
            }else if ($precAnuncio < -1) {
                $mensaje_error = "Debes introducir un precio igual o superior a 0 ";
            } else if ($precAnuncio > 10000) {
                $mensaje_error = "Debes introducir un precio menor a 9999 ";
            } else {
                // Comprobamos que haya alguna foto en el input
                if (!empty($fotoAnuncio)) {
                    // Movemos la foto a el directorio especifico
                    if (move_uploaded_file($foto_temp, $directorio_destino)) {
                        // Inserta los datos a la tabla "Anuncio" con el nombre de la imagen en la base de datos
                        $sql = "INSERT INTO anuncio (nombre_anuncio, precio, descripcion, foto, nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$fotoAnuncio','$usuAnuncio')";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

                        $mensaje_exito = "Se ha creado la publicación";
                        
                        // Restablecer los campos a cadenas vacías después de un envío exitoso
                        $nomAnuncio = '';
                        $descAnuncio = '';
                    }
                } else {
                    // Si o tiene foto inserta el anuncio en la base de datos igualmente y luego lo mostrara con una foto predefinida
                    $sql = "INSERT INTO anuncio (nombre_anuncio, precio, descripcion, nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$usuAnuncio')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

                    $mensaje_exito = "Se ha creado la publicación";
                    
                    // Restablecer los campos a cadenas vacías después de un envío exitoso
                    $nomAnuncio = '';
                    $descAnuncio = '';
                }
            }
        }

        // Comprobamos que haya algo en mensaje_exiti, al no estar vacio muestra el mensaje consecuente
        if (!empty($mensaje_exito)) {
            echo '<div class="mensaje-exito">';
                echo '<p><strong>Éxito!</strong> ' . $mensaje_exito . '</p>';
            echo '</div>';
        } 
        // Si el Mensaje error no esta vacio muestra el mensaje de error consecuente 
        else if (!empty($mensaje_error)) {
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
                <!-- Hacemos que el valor que recoge el input entre en la variavle $nomAnuncio -->
                <input type="text" id="titulo" name="titulo" value="<?php echo $nomAnuncio; ?>">
                
                <label for="descripcion">Descripción:</label>
                <!-- Hacemos que el valor que recoge el textarea entre en la variavle $descAnuncio -->
                <textarea id="descripcion" name="descripcion" rows="4"><?php echo $descAnuncio; ?></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">

                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" min="0" max="10000">
                <button type="submit">Crear Anuncio</button>
            </form>
        </div>
    </section>

    <!-- Incluimos el footer mediante php -->
    <?php
        include('footer.php');
    ?>
</body>
</html>
