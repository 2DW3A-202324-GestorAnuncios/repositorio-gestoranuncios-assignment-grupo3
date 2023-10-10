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
        <!-- Slideshow container -->
        <div class="slideshow-container">
            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                <img src="img/noticia_barca.webp" style="width:100%">
                <div class="text">El Barça logró imponerse a todos sus fantasmas en Oporto</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 3</div>
                <img src="img/noticia_ansu.webp" style="width:100%">
                <div class="text">El plan del Brighton para poner a tope a Ansu Fati: "No queremos presionarle"</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 3</div>
                <img src="img/noticia_mvps_euroliga.webp" style="width:100%">
                <div class="text">Las estrellas que aspiran a coronarse MVP de la Euroliga</div>
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
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

        <a href="anuncio.php"> <button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button>
    </section><br>

    <section id="anuncios-mas-visitados" class="seccion-destacada">
        <div class="seccion-contenido">
            <h2 class="titulo-llamativo">Descubre lo Más Popular</h2>
            <!-- Aquí puedes mostrar tus tres anuncios más visitados -->
            <div class="productos2">
                <div class="producto2">
                    <img src="img/primeraEquip.webp" alt="Producto 1" />
                    <h2>Camiseta Hombre Primera Equipacion</h2>
                    <p>Descripción del Producto 1.</p>
                    <p>85.00€</p>
                    <button>Comprar</button>
                </div>
                <div class="producto2">
                    <img src="img/segundaEquip.webp" alt="Producto 2" />
                    <h2>Camiseta Hombre Primera Equipacion</h2>
                    <p>Descripción del Producto 1.</p>
                    <p>85.00€</p>
                    <button>Comprar</button>
                </div>
                <!-- Agrega más productos aquí -->
                <div class="producto2">
                    <img src="img/segundaEquip.webp" alt="Producto 2" />
                    <h2>Camiseta Hombre Primera Equipacion</h2>
                    <p>Descripción del Producto 1.</p>
                    <p>85.00€</p>
                    <button>Comprar</button>
                </div>
                <!-- Agrega más productos aquí -->
            </div>
        </div>

        <a href="anuncio.php"> <button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button>
        </a>
        </div>
    </section>
    <?php
        include('footer.php');
    ?>
</body>
</html>
