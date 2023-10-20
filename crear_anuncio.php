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
        // Inicia la sesión en la página
        session_start();

        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
            // Comprobar si el usuario es administrador
            $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
        } else {
            include('header_no_sesion.php');
        }


        $insercion = "";
        $usuario = $_SESSION["usuario"];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            include("conexion.php");


            //coje los elementos del formulario
            $nomAnuncio = $_POST['titulo'];
            $descAnuncio = $_POST['descripcion'];
            $precAnuncio = $_POST['precio'];
            $usuAnuncio = $_SESSION["usuario"];
            $fotoAnuncio = $_FILES['imagen']['name'];
            $foto_temp = $_FILES['imagen']['tmp_name'];

            $directorio_destino = 'img/anuncios/' . $fotoAnuncio;

            if (move_uploaded_file($foto_temp, $directorio_destino)) {
                // Inserta los datos a la tabla "Anuncio" con el nombre de la imagen en la base de datos
                $sql = "INSERT INTO anuncio (nombre_anuncio, precio, descripcion, foto,nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$fotoAnuncio','$usuAnuncio')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

                $insercion = "Se ha creado la publicación";
            } else {
                $inserción = "Error al subir la foto.";
            }
            
            
        }
    ?>
    <?php 
        echo'<div>';
            echo'<h3 class="centrado">'.$insercion.'</h3>';
        echo'</div>';
    ?>
    <main>
        <section class="crear-anuncio">
            <h1>Crear un Anuncio</h1>
            <div class="form-crear-anuncio">
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                    
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                    
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" required placeholder="0"><br>
                    <span id="publicacion-creada"><?php echo $insercion ?></span>
                    <button type="submit">Crear Anuncio</button>
                </form>
            </div>
        </section>
    </main>

    <?php
        include('footer.php');
    ?>
    <script>
        //para prevenir el reenvio del formulario al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }  
    </script>
</body>
</html>
