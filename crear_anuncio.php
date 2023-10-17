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
        include("header.php");
        $repeticionPK = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $conn = mysqli_connect("localhost", "root", "", "gestor_anuncios");
        
            // Comprueba conexion
            if($conn === false){
                die("ERROR: No se ha podido conectar. "
                    . mysqli_connect_error());
            }
            $nomAnuncio = $_POST['titulo'];
            $descAnuncio = $_POST['descripcion'];
            $precAnuncio = $_POST['precio'];
            $fotoAnuncio = $_POST['imagen'];
            $usuAnuncio = ...;
           

            //Inserta los datos a la tabla "anuncio"
            mysqli_query($conn,"INSERT INTO anuncio (nombre_anuncio, precio, descripcion, foto, nombre_usuario) VALUES ('$nomAnuncio','$precAnuncio','$descAnuncio','$fotoAnuncio','$usuAnuncio')");
        
            // Cierra conexion
            mysqli_close($conn);    
        
        }
        
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
                    <input type="number" id="precio" name="precio" required placeholder="0">
            
                    <button type="submit">Crear Anuncio</button>
                </form>
            </div>
        </section>
    </main>

    <?php
        include('footer.php');
    ?>
</body>
</html>
