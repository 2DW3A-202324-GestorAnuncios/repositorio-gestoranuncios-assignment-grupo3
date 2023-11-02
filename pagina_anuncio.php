<?php
    // Incluimos la conexion
    include("conexion.php");
    
    // Inicia la sesión en la página
    session_start();

    // Recogemos los datos y los metemos en las variables 
    $id = $_GET['id'];
    $nombre = ucfirst($_GET['nombre']);
    $foto = $_GET['foto'];
    $descripcion = ucfirst($_GET['descripcion']);
    $precio = $_GET['precio'];
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
    <title><?php echo $nombre ?> - CIFP Txurdinaga</title>
</head>
<body>
    <!-- Cargamos el header dependiendo de si la sesion esta iniciada utilizando php -->
    <?php
        // Comprobamos que la session este iniciada y que no este vacia
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <div class="ver-anuncio">
        <?php
            // Cargamos el anuncio con sus datos correspondientes 
            echo '<div>';
                echo '<div class="ver-anuncio-img">';
                    echo '<img src="img/anuncios/' . $foto . '" height="100%" width="100%">';
                echo '</div>';
                echo '<div class="ver-anuncio-contenido">';
                    // Comprobamos la sesion para ver si no es administrador y mostrar o no el boton
                    $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
                    if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
                        if ($admin == 1) {
                            $btnAnadirCarrito = '';
                        } else if ($admin == 0) {
                            $btnAnadirCarrito = '<button class="btn-anadir-carrito" name="btn-anadir-carrito" data-id="' . $id . '" data-foto="' . $foto . '" data-nombre="' . $nombre . '" data-descripcion="' . $descripcion . '" data-precio="' . $precio . '">Añadir al Carrito</button>';
                        }
                    } else {
                        $btnAnadirCarrito = '<button type="button" name="btn-anadir-carrito" onclick="anadirCarritoFormularioInicioSession()">Añadir al Carrito</button>';
                    }
                
                    echo '<h1>' . $nombre . '</h1>';
                    echo '<p>' . $descripcion . '</p>';
                    echo '<h2>Precio: ' . $precio . '€</h2>';
                echo '</div>';
                echo $btnAnadirCarrito;
            echo '</div>';
        ?>
    </div>

    <script>
        const btnAnadirCarrito = document.getElementsByClassName('btn-anadir-carrito');

        // Recorre los botones y deshabilita los que estén en el carrito
        for (const btn of btnAnadirCarrito) {
            const idAnuncio = btn.getAttribute('data-id');
            const estaEnCarrito = carrito.some(item => item.id === idAnuncio);

            // Comprobamos que el anuncio este ya en el localstorage para desavilitar el boton 
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
    
    <!-- Incluimos el footer  -->
    <?php
        include('footer.php');
    ?>
</body>
</html>
