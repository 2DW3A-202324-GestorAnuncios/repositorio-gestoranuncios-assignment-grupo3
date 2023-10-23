<?php
    include("conexion.php");

    $sqlProductos = "SELECT * FROM anuncio WHERE validado = '1'";
    $resultProductos = $conn->query($sqlProductos);

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1' ORDER BY id_noticia DESC LIMIT 3";
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
    <title>Inicio - CIFP Txurdinaga</title>
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

    <section id="ultimas-noticias" class="seccion-destacada"><br>
        <div class="seccion-titulo">
            <h2 class="titulo-llamativo">¡Mantente al Día!</h2><br>
        </div>
        <div class="slideshow-container">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="mySlides fade">';
                    // Comprobar si la noticia tiene una imagen específica o no
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];
                    echo '<a href=""><img src="' . $imagenURL . '" style="width:100%"></a>';
                    echo '<div class="text">' . $row['descripcion'] . '</div>';
                    echo '</div>';
                }
            ?>
            
            <?php
                $slideNumber = 1;
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="mySlides fade">';
                    echo '<div class="numbertext">' . $slideNumber . ' / ' . $resultNoticias->rowCount() . '</div>';
                    // Comprobar si la noticia tiene una imagen específica o no
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];
                    echo '<a href=""><img src="' . $imagenURL . '" style="width:100%"></a>';
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

    <section class="seccion-destacada">
        <div class="seccion-contenido">
            <h2 class="titulo-llamativo">Descubre lo Más Popular</h2>
            <div class="productos-anuncios-inicio">
                <?php
                    while ($row = $resultProductos->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="productos-slide-anuncios">';
                        
                        // Verifica si la URL de la imagen es nula o vacía
                        $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                        $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/anuncios/' . $row['foto'];
                        
                        echo '<a href="pagina_anuncio.php"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '"></a>';
                        echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p class="precio">' . $row['precio'] . '€</p>';
                        echo '<button>Comprar</button>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <a href="anuncio.php"><button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button></a>
    </section>

    <?php
        include('footer.php');
    ?>
</body>
</html>
