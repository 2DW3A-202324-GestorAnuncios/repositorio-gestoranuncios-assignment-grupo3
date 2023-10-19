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

        $repeticionPK = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            include("conexion.php");

            $nomNoticia = $_POST['titulo'];
            $descNoticia = $_POST['descripcion'];
            $catNoticia = $_POST['categoria'];
            $usuNoticia = $_SESSION["usuario"];
           

            //Inserta los datos a la tabla "anuncio"
            $sql = "INSERT INTO noticia (foto, titulo, descripcion, categoria, nombre_usuario) VALUES ('$fotoNoticia','$nomNoticia','$descNoticia','$catNoticia','$usuNoticia')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $insercion= "Se ha creado la publicacion";   
        
        }
    ?>
    <?php 
        echo'<div>';
            echo'<h3 class="centrado">'.$insercion.'</h3>';
        echo'</div>';
    ?>
    <main>
        <section class="crear-noticia">
            <h1>Crear Noticia</h1>
            <div class="form-crear-noticia">
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>

                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="deportes">Deportes</option>
                    <option value="economia">Economía</option>
                    <option value="arte">Arte</option>
                    <option value="tiempo">Tiempo</option>
                </select>
                <button type="submit">Crear Noticia</button>
            </form>
            </div>
        </section>
    </main>

    <?php
        include('footer.php');
    ?>
</body>
</html>
