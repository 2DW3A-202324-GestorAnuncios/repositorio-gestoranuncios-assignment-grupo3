<?php
    include("conexion.php");

    // Inicia la sesión en la página
    session_start();

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
    <?php
        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
            // Comprobar si el usuario es administrador
            $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

            if ($admin == 1) {
                $btnAnadirCarrito = '';
            } else if ($admin == 0) {
                $btnAnadirCarrito = '<button name="btn-anadir-carrito">Añadir al Carrito</button>';
            }
        } else {
            include('header_no_sesion.php');
            $btnAnadirCarrito = '<button type="button" name="btn-anadir-carrito" onclick="anadirCarritoAndToggleDropdown()">Añadir al Carrito</button>';
        }
    ?>

    <div id="buscador">
        <form method="GET" action="anuncio.php" id="search-form">
            <input id="input-buscador" type="text" name="busqueda" placeholder="Buscar por nombre de artículo" value="<?php echo $busqueda; ?>">
        </form>
    </div>

    <?php
        if($totalProductos === 0){
            echo '<div>';
            echo'<p  id="mensajeBusqueda"> No hay resultados para "<b> ' . $busqueda . ' </b>".</p>';
            echo '</div>';
        }
    ?>

    <div class="productos">
        <?php
            while ($row = $stmtProductos->fetch(PDO::FETCH_ASSOC)) {
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                echo '<div class="producto">';
                    echo '<div class="imagen-producto">';
                        echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '</div>';
                    echo '<div class="contenedor-anuncio">';
                        echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p class="precio">' . $row['precio'] . '€</p>';
                    echo '</div>';
                    echo $btnAnadirCarrito;
                echo '</div>';
            }
        ?>
    </div>

    <div id="paginacion">
        <a href="?pagina=<?php echo $paginaActual - 1; ?>" class="botonesPagina <?php if ($paginaActual <= 1) echo 'a-disabled'; ?>">← Anterior</a>
        
        <?php for ($i = 1; $i <= $paginasTotales; $i++): ?>
            <a class="botonesPagina <?php if ($i == $paginaActual) echo 'a-disabled'; ?>" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <a href="?pagina=<?php echo $paginaActual + 1; ?>" class="botonesPagina <?php if ($paginaActual >= $paginasTotales) echo 'a-disabled'; ?>">Siguiente →</a>
    </div>

    <script>
        var inputBuscador = document.getElementById("input-buscador");

        window.addEventListener('load', function() {
            inputBuscador.focus();

            // Colocar el foco al final del campo de entrada
            inputBuscador.setSelectionRange(inputBuscador.value.length, inputBuscador.value.length);
        });

        inputBuscador.addEventListener("keyup", function(event) {
            if (event.keyCode === 13 || event.key === "Enter") {
                var form = document.getElementById("search-form");
                // Enviar el formulario
                form.submit();
            }
        });
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>