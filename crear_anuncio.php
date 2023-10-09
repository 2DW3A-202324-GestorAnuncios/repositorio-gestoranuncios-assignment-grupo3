<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
        
</header>

</head>
<body>
    <div class="container">
        
    </div>
<body>
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
                        <input type="button" value="Crear" class="boton">
                    </div>

            
                </div>
            </form>
        </div>
    </div>
    
    
</body>
<footer>

</footer>
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