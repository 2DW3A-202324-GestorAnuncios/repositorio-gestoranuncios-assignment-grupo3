<?php
    include("conexion.php");

    $sqlProductos = "SELECT * FROM producto";
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
                    echo '<img src="img/anuncios/' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                    echo '<div class="producto-text">';
                    echo '<h2>' . $row['nombre_pro'] . '</h2>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '</div>';
                    echo '<button>Comprar</button>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
