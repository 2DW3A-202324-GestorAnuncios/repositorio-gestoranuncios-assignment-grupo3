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
        include("header.php");
        $repeticionPK = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $conn = mysqli_connect("localhost", "root", "", "gestor_anuncios");
        
            // Comprueba conexion
            if($conn === false){
                die("ERROR: No se ha podido conectar. "
                    . mysqli_connect_error());
            }
            $nomNoticioa = $_POST['titulo'];
            $descNoticia = $_POST['descripcion'];
            $catNoticioa = $_POST['categoria'];
            $fotoNoticioa = $_POST['imagen'];
            $usuNoticia = ...;
           

            //Inserta los datos a la tabla "anuncio"
            mysqli_query($conn,"INSERT INTO anuncio (foto, titulo, descripcion, categoria, nombre_usuario) VALUES ('$fotoNoticia','$nomNoticia','$descAnuncio','$catNoticia','$usuNoticia')");
        
            // Cierra conexion
            mysqli_close($conn);    
        
        }
    ?>
    
    <main>
        <section class="crear-noticia">
            <h1>Crear Noticia</h1>
            <div class="form-crear-noticia">
                <form action="#" method="post">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>

                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="deportes"></option>
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
