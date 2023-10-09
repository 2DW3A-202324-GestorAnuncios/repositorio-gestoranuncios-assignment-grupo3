<!DOCTYPE html>
<html lang="es-Es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <script src="script.js"></script>
    <title>Noticias - CIFP Txurdinaga</title>
  </head>
  <body>
    <?php
      include("header.php");
    ?>
    <section>
      <div class="noticias-carousel">
        <button id="prevButton"> < </button>
        <div class="noticia">
          <img src="img/noticia_barca.webp" alt="Noticia 1">
          <h2>El Barça logró imponerse a todos sus fantasmas en Oporto</h2>
          <p>Ganó por fin fuera de casa un partido importante en Champions y con muchas bajas.</p>
        </div>
        <div class="noticia">
          <img src="img/noticia_ansu.webp" alt="Noticia 2">
          <h2>El plan del Brighton para poner a tope a Ansu Fati: "No queremos presionarle"</h2>
          <p>El español marcó su primer gol en la Premier y continúa creciendo poco a poco en el Brighton.</p>
        </div>
        <div class="noticia">
          <img src="img/noticia_mvps_euroliga.webp" alt="Noticia 3">
          <h2>Las estrellas que aspiran a coronarse MVP de la Euroliga</h2>
          <p>Nikola Mirotic, Wade Baldwin, Mike James, Edy Tavares, Kevin Punter, Will Clyburn, Nikola Milutinov, Facundo Campazzo... son algunos de los jugadores que optan a ser el el mejor de la temporada.</p>
        </div>
        <button id="nextButton">> </button>
    </section>

    <?php
      include('footer.php');
    ?>
  </body>
</html>

