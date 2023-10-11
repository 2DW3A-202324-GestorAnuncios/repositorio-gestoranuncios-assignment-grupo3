<?php
    include("conexion.php");

    $elementosPorPagina = 9;
    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Consulta para obtener el número total de productos
    $sqlTotalProductos = "SELECT COUNT(*) as total FROM producto";
    $resultTotalProductos = $conn->query($sqlTotalProductos);

    if (!$resultTotalProductos) {
        die("Error en la consulta: " . $conn->errorInfo()[2]);
    }

    $totalProductos = $resultTotalProductos->fetch(PDO::FETCH_ASSOC)['total'];

    $paginasTotales = ceil($totalProductos / $elementosPorPagina);

    // Consulta para obtener los productos de la página actual
    $inicio = ($paginaActual - 1) * $elementosPorPagina;
    $sqlProductos = "SELECT * FROM producto LIMIT $inicio, $elementosPorPagina";
    $resultProductos = $conn->query($sqlProductos);
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
        include("header.php");
    ?>

    <section>
        <div class="productos">
            <?php
                while ($row = $resultProductos->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_pro']);
                    echo '<div class = "imagen-producto">';
                    echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '</div>';
                    echo '<div class = "contenedor-anuncio">';
                    echo '<h2>' . $row['nombre_pro'] . '</h2>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p><b>' . $row['precio'] . '€</b></p>';
                    echo '</div>';
                    echo '<button>Comprar</button>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    <div id="paginacion">
        <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?php echo $paginaActual - 1; ?>">Anterior</a>
        <?php endif ?>
        <?php echo $paginaActual . '/' . $paginasTotales; ?>
        <?php if ($paginaActual < $paginasTotales): ?>
            <a class="botonesPagina" href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
        <?php endif ?>
    </div>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>