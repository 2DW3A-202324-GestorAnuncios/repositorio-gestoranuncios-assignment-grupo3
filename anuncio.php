<?php
    //Incluimos la conexion de la base de datos  
    include("conexion.php");

    // Inicia la sesión en la página
    session_start();

    //Generamos el numero especificado de anuncios por pagina en el apartado de anuncios 
    $elementosPorPagina = 9;
    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Inicializa la variable de búsqueda
    $busqueda = '';

    // Verifica si se ha enviado una búsqueda
    if (isset($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
    }

    // Consulta para obtener el número total de productos
    $sqlTotalProductos = "SELECT COUNT(*) as total FROM anuncio WHERE validado = '1'";

    // Si hay una búsqueda, ajusta la consulta para buscar por nombre_anuncio
    if (!empty($busqueda)) {
        $sqlTotalProductos .= " AND nombre_anuncio LIKE :busqueda";
    }

    $stmtTotalProductos = $conn->prepare($sqlTotalProductos);

    // Si hay una búsqueda, vincula el parámetro de búsqueda
    if (!empty($busqueda)) {
        $stmtTotalProductos->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
    }

    $stmtTotalProductos->execute();
    $totalProductos = $stmtTotalProductos->fetchColumn();

    $paginasTotales = ceil($totalProductos / $elementosPorPagina);

    // Define $inicio aquí
    $inicio = ($paginaActual - 1) * $elementosPorPagina;

    // Consulta para obtener los productos de la página actual
    $sqlProductos = "SELECT * FROM anuncio WHERE validado = '1'";

    // Si hay una búsqueda, ajusta la consulta para buscar por nombre_anuncio
    if (!empty($busqueda)) {
        $sqlProductos .= " AND nombre_anuncio LIKE :busqueda";
    }

    $sqlProductos .= " LIMIT $inicio, $elementosPorPagina";

    $stmtProductos = $conn->prepare($sqlProductos);

    // Si hay una búsqueda, vincula el parámetro de búsqueda
    if (!empty($busqueda)) {
        $stmtProductos->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
    }

    $stmtProductos->execute();
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
    <title>Anuncios - CIFP Txurdinaga</title>
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

    <div id="buscador">
        <form method="GET" action="anuncio.php" id="search-form">
            <div id="buscador-encima">
                <!-- Hacemos que el valor que recoge el input entre en la variavle $busqueda -->
                <input id="input-buscador" type="text" name="busqueda" placeholder="Buscar por nombre de artículo" value="<?php echo $busqueda; ?>">
            </div>    
            <div id="buscador-debajo">
                <a href="anuncio.php"><img src="img/botonX.png" id="x"></a>
            </div>
        </form>
    </div>

    <?php
        // Generamos un div con un aviso de que la busqueda no ha dado resultados y mostramos lo que ha buscado el usuario
        if($totalProductos === 0){
            echo '<div>';
                echo'<p id="mensajeBusqueda"> No hay resultados para "<b> ' . $busqueda . ' </b>".</p>';
            echo '</div>';
        }
    ?>

    <div class="productos">
        <?php
            // Cargamos los anuncios desde la base de datos
            while ($row = $stmtProductos->fetch(PDO::FETCH_ASSOC)) {
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/anuncios/' . $row['foto'];

                // Comprobamos que no sea admin, por que al ser admin hacemos que el contenido de "btnAnadirCarrito" este vacio 
                $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
                if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
                    if ($admin == 1) {
                        $btnAnadirCarrito = '';
                    } else if ($admin == 0) {
                        $btnAnadirCarrito = '<button class="btn-anadir-carrito" name="btn-anadir-carrito" data-id="' . $row['id_anuncio'] . '" data-foto="' . $row['foto'] . '" data-nombre="' . $row['nombre_anuncio'] . '" data-descripcion="' . $row['descripcion'] . '" data-precio="' . $row['precio'] . '">Añadir al Carrito</button>';
                    }
                } else {
                    // Si no esta iniciada la sesion al darle al boton te habre el desplegable de inicio sesion
                    $btnAnadirCarrito = '<button type="button" name="btn-anadir-carrito" onclick="anadirCarritoFormularioInicioSession()">Añadir al Carrito</button>';
                }

                echo '<div class="producto">';
                    echo '<div class="imagen-producto">';
                        echo '<a href="pagina_anuncio.php?id='.urlencode($row['id_anuncio']).'&nombre='.urlencode($row['nombre_anuncio']).'&foto='.urlencode($row['foto']).'&descripcion='.urlencode($row['descripcion']).'&precio='.urlencode($row['precio']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '"></a>';
                    echo '</div>';
                    echo '<div id="linea">';
                    echo '</div>';
                    echo '<div class="contenedor-anuncio">';
                        echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p class="precio">' . $row['precio'] . ' €</p>';
                    echo '</div>';
                    echo $btnAnadirCarrito;
                echo '</div>';
            }
        ?>
    </div>

    <div id="paginacion">
        <!-- Hacemos un apartado de paginacion donde se muestran 4 botones fijos -->
        <a href="?pagina=<?php echo $paginaActual - 1; ?>" class="botonesPagina <?php if ($paginaActual <= 1) echo 'a-disabled'; ?>">← Anterior</a>
            <?php
                // Obtener la página actual
                $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

                // Calcular el número total de páginas (supongamos que tienes esto en $paginasTotales)
                // Mostrar la página actual más 2 y la última página
                echo '<div id="paginacion">';
                // Comprobamos que la pagina actual sea la primera para desavilitar el boton
                    if ($paginaActual <= 1) {
                        echo '<a class="botonesPagina a-disabled" href="?pagina= 1">1</a>';
                    } else {
                        echo '<a class="botonesPagina" href="?pagina= 1">1</a>';
                    }
                    echo '...';
                    // Generamos el numero anterior y posterior en base a la pagina en la que esta actualmente
                    for ($i = max(1, $paginaActual - 1); $i <= min($paginaActual + 1, $paginasTotales); $i++) {
                        if($i != 1) {
                            if ($i == $paginasTotales) {
                                echo '...';
                                echo '<a class="botonesPagina ' . ($i == $paginaActual ? 'a-disabled' : '') . '" href="?pagina=' . $i . '">' . $i . '</a>';
                            } else {
                                echo '<a class="botonesPagina ' . ($i == $paginaActual ? 'a-disabled' : '') . '" href="?pagina=' . $i . '">' . $i . '</a>';
                            }
                        }
                    }
                    // Comprobamos que este en la anteultima pagina para que genere el ultimo boton dinamico con tres puntos delante, siguiendo el estilo
                    if ($paginaActual < $paginasTotales - 1) {
                        echo '...';
                        echo '<a class="botonesPagina" href="?pagina=' . $paginasTotales . '">' . $paginasTotales . '</a>';
                    }
                echo '</div>';
            ?>
        <a href="?pagina=<?php echo $paginaActual + 1; ?>" class="botonesPagina <?php if ($paginaActual >= $paginasTotales) echo 'a-disabled'; ?>">Siguiente →</a>
    </div>

    <script>
        // Hacemos que al recargar el buscador haga foco en el campo del buscador 
        var inputBuscador = document.getElementById("input-buscador");

        window.addEventListener('load', function() {
            inputBuscador.focus();

            // Colocar el foco al final del campo de entrada
            inputBuscador.setSelectionRange(inputBuscador.value.length, inputBuscador.value.length);
        });

        // Hacemos que al levantar la tecla de enter haga la busqueda 
        inputBuscador.addEventListener("keyup", function(event) {
            if (event.keyCode === 13 || event.key === "Enter") {
                var form = document.getElementById("search-form");
                // Enviar el formulario
                form.submit();
            }
        });
        
        // Creamos la variable de boton carrito para poder meter el anuncio seleccionado en el localstorage
        const btnAnadirCarrito = document.getElementsByClassName('btn-anadir-carrito');
        // Recorre los botones y deshabilita los que estén en el carrito
        for (const btn of btnAnadirCarrito) {
            const idAnuncio = btn.getAttribute('data-id');
            const estaEnCarrito = carrito.some(item => item.id === idAnuncio);

            //Comprovamos que si esta en el localstorage desavilite el boton
            if (estaEnCarrito) {
                btn.disabled = true;
                btn.style.backgroundColor = '#ccc';
                btn.style.color = '#666';
                btn.style.cursor = 'not-allowed';
            }

            // Recogemos los datos del anuncio para crear un objeto
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

                // Metemos dentro del carrito el objeto que acabamos de crear
                carrito.push(nuevoProducto);

                // Almacenar la lista actualizada en localStorage
                localStorage.setItem('carrito => ' + usuario, JSON.stringify(carrito));

                // Deshabilitar el botón después de hacer clic
                btn.disabled = true;
                btn.style.backgroundColor = '#ccc';
                btn.style.color = '#666';
                btn.style.cursor = 'not-allowed';
                
                // Creamos la variable de numeroCarrito para que sume al insertar el objeto al localstorage
                let numeroCarrito = document.getElementById('numero-carrito');
                numeroCarrito.innerText = parseInt(numeroCarrito.innerText) + 1;
            });
        }
    </script>

    <!-- Incluimos el footer mediante php -->
    <?php
        include('footer.php');
    ?>
</body>
</html>
