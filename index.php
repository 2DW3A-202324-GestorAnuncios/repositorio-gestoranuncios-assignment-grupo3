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

    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '1' ORDER BY id_noticia DESC LIMIT 5";
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
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <section id="ultimas-noticias" class="seccion-destacada">
        <h2 class="titulo-llamativo">¡Mantente al Día!</h2>
        <div class="carousel">
            <div class="carousel__body">
                <div class="carousel__slider">
                <?php
                    while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    // Verifica si la URL de la imagen es nula o vacía
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];                   
                    echo '<div class="carousel__slider__item">';
                        echo '<div class="item__3d-frame">';
                            echo '<div class="item__3d-frame__box item__3d-frame__box--front">';
                            echo '<div class="slideshow-container">';
                                echo '<a href="pagina_noticias.php?titulo='.urlencode($row['titulo']).'&foto='.urlencode($row['foto']).'&categoria='.urlencode($row['categoria']).'&descripcion='.urlencode($row['descripcion']).'"><img src="' . $imagenURL . '" style="width:100%"></a>';
                                echo '<div class="text">' . $row['descripcion'] . '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="item__3d-frame__box item__3d-frame__box--left"></div>';
                            echo '<div class="item__3d-frame__box item__3d-frame__box--right"> </div>';
                        echo '</div>';
                    echo '</div>';
                    }
                ?>
                </div>
                <div class="carousel__prev"><p>&#10094;</p></div>
                <div class="carousel__next"><p>&#10095;</p></div>
                
            </div>
        </div>

        <script>
            (function() {
            "use strict";

            var carousel = document.getElementsByClassName('carousel')[0],
                slider = carousel.getElementsByClassName('carousel__slider')[0],
                items = carousel.getElementsByClassName('carousel__slider__item'),
                prevBtn = carousel.getElementsByClassName('carousel__prev')[0],
                nextBtn = carousel.getElementsByClassName('carousel__next')[0];
            
            var width, height, totalWidth, margin = 20,
                currIndex = 0,
                interval, intervalTime = 4000;
            
            function init() {
                resize();
                move(Math.floor(items.length / 2));
                bindEvents();
                
                timer();
            }
            function resize() {
                width = Math.max(window.innerWidth * .25, 275),
                height = window.innerHeight * .5,
                totalWidth = width * items.length;
                slider.style.width = totalWidth+"px";
                for(var i = 0; i < items.length; i++) {
                    let item = items[i];
                    item.style.width = (width - (margin * 2)) + "px";
                    item.style.height = height + "px";
                }
            }
            function move(index) {
                if(index < 1) index = items.length;
                if(index > items.length) index = 1;
                currIndex = index;
                
                for(var i = 0; i < items.length; i++) {
                    let item = items[i],
                        box = item.getElementsByClassName('item__3d-frame')[0];
                    if(i == (index - 1)) {
                        item.classList.add('carousel__slider__item--active');
                        box.style.transform = "perspective(1200px)"; 
                    } else {
                        item.classList.remove('carousel__slider__item--active');
                        box.style.transform = "perspective(1200px) rotateY(" + (i < (index - 1) ? 40 : -40) + "deg)";
                    }
                }
                slider.style.transform = "translate3d(" + ((index * -width ) -25 +  (width / 2) + window.innerWidth / 2) + "px, 0, 0)";
            }
            function timer() {
                clearInterval(interval);    
                interval = setInterval(() => {
                    move(++currIndex);
                }, intervalTime);    
            }
            function prev() {
                move(--currIndex);
                timer();
            }
            function next() {
                move(++currIndex);    
                timer();
            }
            function bindEvents() {
                window.onresize = resize;
                prevBtn.addEventListener('click', () => { prev(); });
                nextBtn.addEventListener('click', () => { next(); });    
            }
            init();
        })();
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

                    echo '<div class="productos-slide-anuncios">';
                        echo '<div class="imagen-producto">';
                            echo '<a href="pagina_anuncio.php?id='.urlencode($row['id_anuncio']).'&nombre='.urlencode($row['nombre_anuncio']).'&foto='.urlencode($row['foto']).'&descripcion='.urlencode($row['descripcion']).'&precio='.urlencode($row['precio']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '"></a>';
                        echo '</div>';
                        echo '<div class = "contenedor-anuncio">';
                            echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                            echo '<p>' . $row['descripcion'] . '</p>';
                            echo '<p class="precio">' . $row['precio'] . ' €</p>';
                        echo '</div>';
                        echo $btnAnadirCarrito;
                    echo '</div>';
                }
            ?>
        </div>
        <a href="anuncio.php"><button id="ver-mas-anuncios" class="ver-mas-button">Ver Más Anuncios</button></a>
    </section>

    <script>

        const btnAnadirCarrito = document.getElementsByClassName('btn-anadir-carrito');

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
                
                let numeroCarrito = document.getElementById('numero-carrito');
                numeroCarrito.innerText = parseInt(numeroCarrito.innerText) + 1;
            });
        }



            
    </script>

    
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
