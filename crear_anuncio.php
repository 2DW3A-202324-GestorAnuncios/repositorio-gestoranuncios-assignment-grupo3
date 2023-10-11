<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Crear Publicación - CIFP Txurdinaga</title>
</head>
<body>
    <div class="container">
        
    </div>
<body>
    <?php
        include('header.php');
    ?>

    <div class="grid_crear">
        <div class="barra_lateral">

        </div>
        <div>
            <form class="crear_publicacion">
                <div class="creacion_p1">
                    <div>
                        <p>Titulo:</p>
                        <input type="text" class="input_titulo">
                    </div>
                    <div>
                        <p class="texto_insertar_imagen">Imagen:</p>
                        <div class="seleccionar_imagen">
                            <input type="file" accept="image/*" id="imagen" onchange="loadFile(event)">
                        </div>
                        <img id="output"/>

                    </div>
                </div>
                <p>Descripcion:</p>
                <div class="comment">
                    <textarea class="descripcion" placeholder="Comment"></textarea>
                </div>
                <p class="texto_anuncio">Es un anuncio?</p>                
                <div class="creacion_p3">
                    <div>
                        <input type="button" value="Crear" class="boton" >
                    </div>

            
                </div>
            </form>
        </div>
    </div>

    <?php
        include('footer.php');
    ?>
</body>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) 
        }
    };
</script>
</html>