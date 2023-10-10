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
        include("conexion.php");

        $sql = "SELECT * FROM producto";
        $result = $conn->query($sql);
    ?>

    <?php
        include("header.php");
    ?>

    <section>
        <div class="productos">
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="producto">';
                
                // Verifica si la URL de la imagen es nula o vacía
                $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['nombre_pro']);
                
                echo '<img src="' . $row['foto'] . '" alt="' . htmlspecialchars($imagenAlt) . '">';
                echo '<h2>' . $row['nombre_pro'] . '</h2>';
                echo '<p>' . $row['descripcion'] . '</p>';
                echo '<p>' . $row['precio'] . '€</p>';
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
