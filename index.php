<?php
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();
    
    // Inicializa un array para almacenar los productos seleccionados
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $sqlProductos = "SELECT * FROM anuncio WHERE validado = '1' ORDER BY id_anuncio DESC LIMIT 10";
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
            $usuario = $_SESSION['usuario'];
        } else {
            include('header_no_sesion.php');
            $usuario = null;
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
                    echo '<img src="' . $imagenURL . '" style="width:100%">';
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
                            $btnAnadirCarrito = '<button class="btn-anadir-carrito" name="btn-anadir-carrito" data-id="' . $row['id_anuncio'] . '" data-foto="' . $row['foto'] . '" data-nombre="' . $row['nombre_anuncio'] . '" data-descripcion="' . $row['descripcion'] . '" data-precio="' . $row['precio'] . '">Añadir al Carrito</button>';
                        }
                    } else {
                        $btnAnadirCarrito = '<button type="button" name="btn-anadir-carrito" onclick="anadirCarritoAndToggleDropdown()">Añadir al Carrito</button>';
                    }
                }
                ?>
            </div>
        </div>
        <a href="anuncio.php"><button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button></a>
    </section>

    <script>
        const btnAnadirCarrito = document.getElementsByClassName('btn-anadir-carrito');
        const usuario = "<?php echo $usuario; ?>";

        // Obtener la lista de productos del carrito desde localStorage (si existe)
        const carrito = JSON.parse(localStorage.getItem('carrito => ' + usuario)) || [];

        // Recorre los botones y deshabilita los que estén en el carrito
        for (const btn of btnAnadirCarrito) {
            const idAnuncio = btn.getAttribute('data-id');
            const estaEnCarrito = carrito.some(item => item.id === idAnuncio);

            if (estaEnCarrito) {
                btn.disabled = true;
                btn.style.backgroundColor = '#ccc';
                btn.style.color = '#666';
                btn.style.cursor = 'not-allowed';
            }

            btn.addEventListener('click', (e) => {
                const fotoAnuncio = e.currentTarget.getAttribute('data-foto');
                const nombreAnuncio = e.currentTarget.getAttribute('data-nombre');
                const descripcionAnuncio = e.currentTarget.getAttribute('data-descripcion');
                const precioAnuncio = e.currentTarget.getAttribute('data-precio');

                // Agregar el nuevo producto al carrito
                const nuevoProducto = {
                    id: idAnuncio,
                    foto: fotoAnuncio,
                    nombre: nombreAnuncio,
                    descripcion: descripcionAnuncio,
                    precio: precioAnuncio
                };

                carrito.push(nuevoProducto);

                // Almacenar la lista actualizada en localStorage
                localStorage.setItem('carrito => ' + usuario, JSON.stringify(carrito));

                // Deshabilitar el botón después de hacer clic
                btn.disabled = true;
                btn.style.backgroundColor = '#ccc';
                btn.style.color = '#666';
                btn.style.cursor = 'not-allowed';
            });
        }
    </script>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
