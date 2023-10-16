<?php
    include("conexion.php");

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
    <title>Anuncios - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        include("header.php");
    ?>
    <div id="buscador">
        <form method="GET" action="anuncio.php" id="search-form">
            <input onkeyup="submitForm()" id="inputBuscador" type="text" name="busqueda" placeholder="Buscar por nombre de artículo 🔍" value="<?php echo $busqueda; ?>">
        </form>
    </div>

    <script>
        var inputBuscador = document.getElementById("inputBuscador");

        window.addEventListener('load', function() {
            inputBuscador.focus();

            // Colocar el foco al final del campo de entrada
            inputBuscador.setSelectionRange(inputBuscador.value.length, inputBuscador.value.length);
        });
        function submitForm() {
            // Obtener el formulario por su ID
            var form = document.getElementById("search-form");
            // Enviar el formulario
            form.submit();
        }
    </script>
        <div class="productos">
            <?php
            if($totalProductos === 0){
                echo '<div>';
                echo'<p  id="mensajeBusqueda"> Lo sentimos, su busqueda "<b>'.$busqueda.'</b>" no se ha encontrado </p>';
                echo '</div>';

            }
                while ($row = $stmtProductos->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="producto">';
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_anuncio']);
                    echo '<div class = "imagen-producto">';
                    echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '</div>';
                    echo '<div class = "contenedor-anuncio">';
                    echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p class="precio">' . $row['precio'] . '€</p>';
                    echo '</div>';
                    echo '<button>Comprar</button>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    <div id="paginacion">
        <a href="?pagina=<?php echo $paginaActual - 1; ?>" class="botonesPagina <?php if ($paginaActual <= 1) echo 'a-disabled'; ?>">← Anterior</a>
        
        <?php for ($i = 1; $i <= $paginasTotales; $i++): ?>
            <a class="botonesPagina <?php if ($i == $paginaActual) echo 'a-disabled'; ?>" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <a href="?pagina=<?php echo $paginaActual + 1; ?>" class="botonesPagina <?php if ($paginaActual >= $paginasTotales) echo 'a-disabled'; ?>">Siguiente →</a>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>