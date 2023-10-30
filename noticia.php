<?php
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();

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
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <div class="container">
        <div class="filtro-container">
            <div class="filtro">
                <h2>Filtrar por Categoría</h2>
                <!-- Agrega el enlace "Borrar filtros" debajo del título -->
                <a href="noticia.php" id="borrarFiltros" style="display: none;">Borrar filtros</a><br>
                <form id="filtroForm">
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-deportes" value="deportes">
                        <img id="deportes" src="img/categorias_noticias/deporte.png" alt="Deportes">
                        <h3 style="margin-top: 5px;">Deportes</h3>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-economia" value="economia">
                        <img id="economia" src="img/categorias_noticias/economia.png" alt="Economía">
                        <h3 style="margin-top: 5px;">Economía</h3>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-arte" value="arte">
                        <img id="arte" src="img/categorias_noticias/arte.png" alt="Arte">
                        <h3 style="margin-top: 5px;">Arte</h3>
                    </label><br>
                    <label class="filtro-label">
                        <input type="radio" name="categoria" id="categoria-tiempo" value="tiempo">
                        <img id="tiempo" src="img/categorias_noticias/tiempo.png" alt="Tiempo">
                        <h3 style="margin-top: 5px;">Tiempo</h3>
                    </label><br>
                </form>
            </div>
        </div>

        <div class="noticias3">
            <h1 id="noticia-tipo">Noticias </h1>
            <div id="noticiasContainer" class="noticias-container">
                <?php 
                    while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                        $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['titulo']);
                        $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];
                        echo '<div class="noticia3 categoria-' . $row['categoria'] . '">';
                            echo '<a href="pagina_noticias.php?titulo='.urlencode($row['titulo']).'&foto='.urlencode($row['foto']).'&categoria='.urlencode($row['categoria']).'&descripcion='.urlencode($row['descripcion']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '" class="imagen-noticia3"></a>';
                            echo '<h1 class="titulo-noticia3-h1">' . $row['categoria'] . '</h1>';
                            echo '<h2 class="titulo-noticia3">' . $row['titulo'] . '</h2>';
                            echo '<input type="hidden" value="'.$row['descripcion'].'">';
                        echo '</div>';
                    }
                    
                    
                ?>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtén una referencia al formulario de filtro
            const filtroForm = document.getElementById("filtroForm");

            // Obtén una referencia al enlace "Borrar filtros"
            const borrarFiltrosLink = document.getElementById("borrarFiltros");

            // Agrega un evento de cambio al formulario
            filtroForm.addEventListener("change", function() {
                // Obtén el valor de la categoría seleccionada
                const selectedCategoria = document.querySelector('input[name="categoria"]:checked').value;
                const noticiaTipo = document.getElementById("noticia-tipo");

                noticiaTipo.innerText = selectedCategoria.toUpperCase();
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

                // Muestra el enlace "Borrar filtros" cuando se aplique algún filtro
                borrarFiltrosLink.style.display = "block";
            });

            // Agrega un evento de clic al enlace "Borrar filtros"
            borrarFiltrosLink.addEventListener("click", function() {
                // Restablece el formulario de filtro (quita todas las selecciones)
                filtroForm.reset();

                // Muestra todas las noticias nuevamente
                noticias.forEach(function(noticia) {
                    noticia.style.display = "block";
                });

                // Oculta el enlace "Borrar filtros" nuevamente
                borrarFiltrosLink.style.display = "none";
            });
        });
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>
