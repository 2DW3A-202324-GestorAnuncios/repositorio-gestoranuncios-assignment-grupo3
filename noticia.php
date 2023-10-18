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
    <title>Noticias - CIFP Txurdinaga</title>
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
    ?>

    <div class="container">
        <div class="filtro-container">
            <div class="filtro">
                <h3>Filtrar por Categoría</h3><br><br>
                <form id="filtroForm">
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-deportes" value="deportes">
                        <img src="img/categorias_noticias/deporte.png" alt="Deportes">
                        <h5 style="margin-top: 5px;">Deportes</h5>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-economia" value="economia">
                        <img src="img/categorias_noticias/economia.png" alt="Economía">
                        <h5 style="margin-top: 5px;">Economía</h5>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-arte" value="arte">
                        <img src="img/categorias_noticias/arte.png" alt="Arte">
                        <h5 style="margin-top: 5px;">Arte</h5>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-tiempo" value="tiempo">
                        <img src="img/categorias_noticias/tiempo.png" alt="Tiempo">
                        <h5 style="margin-top: 5px;">Tiempo</h5>
                    </label><br>
                </form>
            </div>
        </div>
        <div class="noticias3">
            <h2>Noticias</h2>
            <div id="noticiasContainer" class="noticias-container">
                <?php
                    while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="noticia3 categoria-' . $row['categoria'] . '">';
                        
                        echo '<img src="img/noticias/' . $row['foto'] . '" alt="' . htmlspecialchars($row['titulo']) . '" class="imagen-noticia3">';
                        echo '<h1 class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtén una referencia al formulario de filtro
        const filtroForm = document.getElementById("filtroForm");

        // Agrega un evento de cambio al formulario
        filtroForm.addEventListener("change", function() {
            // Obtén el valor de la categoría seleccionada
            const selectedCategoria = document.querySelector('input[name="categoria"]:checked').value;

            // Obtén todas las noticias
            const noticias = document.querySelectorAll('.noticia3');

            // Recorre todas las noticias y ocúltalas si no coinciden con la categoría seleccionada
            noticias.forEach(function(noticia) {
                const categoriaNoticia = noticia.className.match(/categoria-(\w+)/)[1];

                if (selectedCategoria === "todas" || selectedCategoria === categoriaNoticia) {
                    noticia.style.display = "block";
                } else {
                    noticia.style.display = "none";
                }
            });
        });
    });
    </script>
</body>