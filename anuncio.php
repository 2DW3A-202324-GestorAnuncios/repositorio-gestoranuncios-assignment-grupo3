<!DOCTYPE html>
<html lang="es-Es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="../reto/img/logotxur.png">
    <script src="script.js"></script>
    <title>Anuncios - CIFP Txurdinaga</title>
  </head>
  <body>
    <header>
      <a href="index.php">
        <img src="img/Logo_Home3.png" alt="Inicio" width="400px" height="150px">
      </a>
      <div class="header-buttons">
        <button class="login-button">Iniciar Sesión</button>
      </div>
    </header>
    <div class="barranav">
      <a href="index.php" class="menu-item inicio">Inicio</a>
      <a href="noticia.php" class="menu-item noticias">Noticias</a>
      <a href="anuncio.php" class="menu-item anuncios">Anuncios</a>
      <a href="contacto.php" class="menu-item contacto">Contacto</a>
    </div>
    <section>
      <div class="productos">
        <div class="producto">
          <img src="producto1.jpg" alt="Producto 1">
          <h2>Nombre del Producto 1</h2>
          <p>Descripción del Producto 1.</p>
          <p>Precio: $XX.XX</p>
          <button>Comprar</button>
        </div>
        <div class="producto">
          <img src="img/producto2.jpg" alt="Producto 2">
          <h2>Nombre del Producto 2</h2>
          <p>Descripción del Producto 2.</p>
          <p>Precio: $XX.XX</p>
          <button>Comprar</button>
        </div>
        <!-- Agrega más productos aquí -->
      </div>
    </section>

    <?php
      include('footer.php');
    ?>
  </body>
</html>
