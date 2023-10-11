<?php
    include("conexion.php");

    $sqlProductos = "SELECT * FROM producto";
    $resultProductos = $conn->query($sqlProductos);

    $sqlNoticias = "SELECT * FROM noticia";
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
    <title>Inicio - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        include("header.php");
    ?>

    <section id="ultimas-noticias" class="seccion-destacada"><br>
        <div class="seccion-titulo">
            <h2 class="titulo-llamativo">¡Mantente al Día!</h2><br>
        </div>
        <div class="slideshow-container">
            <?php
                $slideNumber = 1;
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="mySlides fade">';
                    echo '<div class="numbertext">' . $slideNumber . ' / ' . $resultNoticias->rowCount() . '</div>';

                    // Comprobar si la noticia tiene una imagen específica o no
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];

                    echo '<img src="' . $imagenURL . '" style="width:100%">';
                    echo '<div class="text">' . $row['descripcion'] . '</div>';
                    echo '</div>';
                    $slideNumber++;
                }
            ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>
        <div style="text-align:center">
            <?php
            // Generar puntos (indicadores) dinámicamente
            for ($i = 1; $i <= $resultNoticias->rowCount(); $i++) {
                echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span>';
            }
            ?>
        </div>

        <script>
            let slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("dot");
                if (n > slides.length) {
                    slideIndex = 1;
                }
                if (n < 1) {
                    slideIndex = slides.length;
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            }

            // Añade esta función para cambiar de diapositiva cada 10 segundos
            function autoSlide() {
                plusSlides(1);
            }

            // Llama a autoSlide cada 10 segundos (10000 milisegundos)
            setInterval(autoSlide, 10000);
        </script>

        <a href="noticia.php"><button id="ver-mas-noticias" class="ver-mas-button">Ver Más Noticias</button></a>
    </section>

    <section id="anuncios-mas-visitados" class="seccion-destacada">
        <div class="seccion-contenido">
            <h2 class="titulo-llamativo">Descubre lo Más Popular</h2>
            <div class="productos2">
                <?php
                while ($row = $resultProductos->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto2">';
                    
                    // Verifica si la URL de la imagen es nula o vacía
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_pro']);
                    
                    echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '<h2>' . $row['nombre_pro'] . '</h2>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p>' . $row['precio'] . '€</p>';
                    echo '<button>Comprar</button>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <a href="anuncio.php"><button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button></a>
        </div>
    </section>

    <?php
        include('footer.php');
    ?>
</body>
</html>