<!DOCTYPE html>
<html lang="es-Es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css" />
    <link rel="stylesheet" href="hojaEstilos/fuentes.css" />
    <link rel="stylesheet" href="hojaEstilos/estilos.css" />
    <link rel="shortcut icon" href="img/favicon.png" />
    <script src="script.js"></script>
    <title>Inicio - CIFP Txurdinaga</title>
</head>

<body>
    <?php
      include("header.php");
    ?>

    <section><br>
        <div class="noticias2">
            <button id="anterior" class="carousel-button">&#10094;</button>
            <div class="noticia">
                <img src="img/noticia_ansu.webp" alt="Noticia Ansu" class="imagen-noticia">
                <h2 class="titulo-noticia">Noticia Ansu</h2>
            </div>
            <div class="noticia">
                <img src="img/noticia_barca.webp" alt="Noticia Barca" class="imagen-noticia">
                <h2 class="titulo-noticia">Noticia Deudas</h2>
            </div>
            <div class="noticia">
                <img src="img/noticia_mvps_euroliga.webp" alt="MVPs EuroLiga" class="imagen-noticia">
                <h2 class="titulo-noticia">MVPs EuroLiga</h2>
            </div>
            <button id="siguiente" class="carousel-button">&#10095;</button>
        </div>
    </section><br>

    <?php
      include('footer.php');
    ?>
</body>

</html>