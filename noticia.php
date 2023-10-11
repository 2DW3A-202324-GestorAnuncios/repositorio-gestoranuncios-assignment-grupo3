<?php
    include("conexion.php");

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1'";
    $resultNoticias = $conn->query($sqlNoticias);
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
	<script src="script.js"></script>
	<title>Noticias - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        include("header.php");
    ?>

    <div class="container">
        <div class="filtro">
            <h3>Filtrar por Categoría</h3>
            <form id="filtroForm">
                <label class="filtro-label">
                    <input type="radio" name="categoria" value="deportes">
                    <img src="img/categorias_noticias/deporte.png" alt="Deportes">
                    <h5>Deportes</h5>
                </label><br>
                <label class="filtro-label">
                    <input type="radio" name="categoria" value="arte">
                    <img src="img/categorias_noticias/arte.png" alt="Arte">
                    <h5>Arte</h5>
                </label><br>
                <label class="filtro-label">
                    <input type="radio" name="categoria" value="economia">
                    <img src="img/categorias_noticias/economia.png" alt="Economía">
                    <h5>Economia</h5>
                </label><br>
                <label class="filtro-label">
                    <input type="radio" name="categoria" value="tiempo">
                    <img src="img/categorias_noticias/tiempo.png" alt="Tiempo">
                    <h5>Tiempo</h5>
                </label><br>
            </form>
        </div>
        <div class="noticias3">
            <h2>Noticias</h2>
            <div id="noticiasContainer" class="noticias-container">
                <?php
                    while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="noticia3 categoria-' . $row['categoria'] . '">';
                        echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                        echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        include('footer.php');
    ?>
</body>
</html>
