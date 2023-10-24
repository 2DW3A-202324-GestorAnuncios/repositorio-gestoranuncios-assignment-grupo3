<?php
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();
    
    // Inicializa un array para almacenar los productos seleccionados
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $sqlProductos = "SELECT * FROM anuncio WHERE validado = '1'";
    $resultProductos = $conn->query($sqlProductos);

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1' ORDER BY id_noticia DESC LIMIT 3";
    $resultNoticias = $conn->query($sqlNoticias);

    // Verifica si se hizo clic en "Añadir al Carrito"
    if (isset($_POST['btn-anadir-carrito'])) {
        // Recuperar los valores del producto
        $fotoProducto = $_POST['foto_producto'];
        $nombreProducto = $_POST['nombre_producto'];
        $precioProducto = $_POST['precio_producto'];

        // Agrega el producto al array de carrito de la sesión
        $_SESSION['carrito'][] = array('foto' => $fotoProducto, 'nombre' => $nombreProducto, 'precio' => $precioProducto);
    }
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
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <section id="ultimas-noticias" class="seccion-destacada">
        <h2 class="titulo-llamativo">¡Mantente al Día!</h2>
        <div class="slideshow-container">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
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
                }
            ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

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

    <section id="ultimos-anuncios" class="seccion-destacada">
        <h2 class="titulo-llamativo">Descubre lo Más Popular</h2>
        <div class="productos-anuncios-inicio">
            <?php
                while ($row = $resultProductos->fetch(PDO::FETCH_ASSOC)) {
                    // Verifica si la URL de la imagen es nula o vacía
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/anuncios/' . $row['foto'];
                    
                    $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
                    if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
                        if ($admin == 1) {
                            $btnAnadirCarrito = '';
                        } else if ($admin == 0) {
                            $btnAnadirCarrito = '
                            <form method="post" action="carrito_compra.php">
                                <input type="hidden" name="foto_producto" value="' . $row['foto'] . '">
                                <input type="hidden" name="nombre_producto" value="' . $row['nombre_anuncio'] . '">
                                <input type="hidden" name="precio_producto" value="' . $row['precio'] . '">
                                <button type="submit" name="btn-anadir-carrito">Añadir al Carrito</button>
                            </form>';
                        }
                    } else {
                        $btnAnadirCarrito = '<button type="button" name="btn-anadir-carrito" onclick="anadirCarritoAndToggleDropdown()">Añadir al Carrito</button>';
                    }

                    echo '<div class="productos-slide-anuncios">';
                        echo '<div class="imagen-producto">';
                            echo '<img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                        echo '</div>';
                        echo '<div class = "contenedor-anuncio">';
                            echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                            echo '<p>' . $row['descripcion'] . '</p>';
                            echo '<p class="precio">' . $row['precio'] . '€</p>';
                        echo '</div>';
                        echo $btnAnadirCarrito;
                    echo '</div>';
            ?>
        </div>
        <a href="anuncio.php"><button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button></a>
    </section>

    <?php
        include('footer.php');
    ?>
</body>
</html>
