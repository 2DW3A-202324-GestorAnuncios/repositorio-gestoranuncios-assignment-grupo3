<?php
    // Incluimos la conexion con la base de datos
    include("conexion.php");

    // Inicia la sesión en la página
    session_start();

    // Creamos una funcion de php que eliminara la foto de la publicacion seleccionado
    function eliminarFoto($nombreArchivo, $tipoPublicacion) {
        $directorio_destino = 'img/'.$tipoPublicacion.'/' . $nombreArchivo;
        if (file_exists($directorio_destino)) {
            unlink($directorio_destino); // Borra el archivo
        }
    }

    // Hacemos un select de todos los anuncios que esten sin validar 
    $sqlAnuncios = "SELECT * FROM anuncio WHERE validado = '0'";
    $resultAnuncios = $conn->query($sqlAnuncios);

    // Comprobamos que se ha enviafdo el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Comprobamos que el formulario enviado sea el de "validar_anuncio"
        if (isset($_POST["validar_anuncio"])) {
            $id_anuncio = $_POST["validar_anuncio"];

            // Realiza una consulta SQL para actualizar el campo validado a 1
            $sqlValidarAnuncio = "UPDATE anuncio SET validado = '1' WHERE id_anuncio = :id_anuncio";

            $stmt = $conn->prepare($sqlValidarAnuncio);
            $stmt->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
            $stmt->execute();

            $resultAnuncios = $conn->query($sqlAnuncios);
        } 
        // Comprobamos que el formulario enviado sea el de "eliminar_anuncio"
        else if (isset($_POST["eliminar_anuncio"])) {
            $id_anuncio = $_POST["eliminar_anuncio"];
                        
            // Realiza una consulta SQL para seleccionar la foto del anuncio 
            $sqlFotoAnuncio = "SELECT foto FROM anuncio WHERE id_anuncio = :id_anuncio";
            $stmtFotoAnuncio = $conn->prepare($sqlFotoAnuncio);
            $stmtFotoAnuncio->bindValue(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
            $stmtFotoAnuncio->execute();
            $sacarFotoAnuncio = $stmtFotoAnuncio->fetch();
            
            // Metemos la foto en una variable para poder eliminarla de la carpeta
            $fotoAnuncio = $sacarFotoAnuncio['foto'];
    
            // Realiza una consulta SQL para borrar todo el anuncio
            $sqlEliminarAnuncio = "DELETE FROM anuncio WHERE id_anuncio = :id_anuncio";
            $stmt = $conn->prepare($sqlEliminarAnuncio);
            $stmt->bindParam(':id_anuncio', $id_anuncio, PDO::PARAM_INT);
            $stmt->execute();

            // Si la variable "fotoAnuncio" no esta vacia llamamos a la funcion de "eliminarFoto"
            if (!empty($fotoAnuncio)) {
                eliminarFoto($fotoAnuncio, 'anuncios');
            }
    
            $resultAnuncios = $conn->query($sqlAnuncios);
        }
    }
    
    // Hacemos un select de todas las noticiass que esten sin validar 
    $sqlNoticias = "SELECT * FROM noticia WHERE validado = '0'";
    $resultNoticias = $conn->query($sqlNoticias);


    // Comprobamos que se ha enviafdo el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Comprobamos que el formulario enviado sea el de "validar_noticia"
        if (isset($_POST["validar_noticia"])) {
            $id_noticia = $_POST["validar_noticia"];

            // Realiza una consulta SQL para actualizar el campo validado a 1
            $sqlValidarNoticia = "UPDATE noticia SET validado = '1' WHERE id_noticia = :id_noticia";

            $stmt = $conn->prepare($sqlValidarNoticia);
            $stmt->bindValue(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmt->execute();

            $resultNoticias = $conn->query($sqlNoticias);
        } 
        // Comprobamos que el formulario enviado sea el de "eliminar_noticia"
        else if (isset($_POST["eliminar_noticia"])) {
            $id_noticia = $_POST["eliminar_noticia"];

            // Realiza una consulta SQL para seleccionar la foto de la noticia 
            $sqlFotoNoticia = "SELECT foto FROM noticia WHERE id_noticia = :id_noticia";
            $stmtFotoNoticia = $conn->prepare($sqlFotoNoticia);
            $stmtFotoNoticia->bindValue(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmtFotoNoticia->execute();
            $sacarFotoNoticia = $stmtFotoNoticia->fetch();

            // Metemos la foto en una variable para poder eliminarla de la carpeta
            $fotoNoticia = $sacarFotoNoticia['foto'];

            // Realiza una consulta SQL para borrar toda la noticia
            $sqlEliminarNoticia = "DELETE FROM noticia WHERE id_noticia = :id_noticia";
            $stmt = $conn->prepare($sqlEliminarNoticia);
            $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmt->execute();

            // comprobamos que la foto de la noticia no este vacia y llamamos a la funcion de "eliminarFoto"
            if (!empty($fotoNoticia)) {
                eliminarFoto($fotoNoticia, 'noticias');
            }

            $resultNoticias = $conn->query($sqlNoticias);
        }
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
    <title>Validación - CIFP Txurdinaga</title>
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

    <section class="seccion-destacada">
        <div class="seccion-titulo">
            <h1 class="titulo-llamativo">Validación de Anuncios</h1>
        </div>
        <div class="productos">
            <?php
                // Mediante un while cargamos todos los anuncios que no esten validados 
                while ($row = $resultAnuncios->fetch(PDO::FETCH_ASSOC)) {
                    $nombre_anuncio = $row['nombre_anuncio'];

                    // Comprobamos que el anuncio tenga foto, si no tiene le ponemos una por defecto
                    if (empty($row['foto'])) {
                        $imagenURL = 'img/sin-foto.jpg';
                        $imagenAlt = 'Sin Foto';
                    } else {
                        $imagenURL = 'img/anuncios/' . $row['foto'];
                        $imagenAlt = ucfirst($row['nombre_anuncio']);
                    }
                    // Cargamos los campos del anuncio y le añadimos dos botones
                    echo '<form class="producto" method="POST" action="validar.php">';
                        echo '<div class="imagen-producto">';
                            echo '<a href="pagina_anuncio.php?id='.urlencode($row['id_anuncio']).'&nombre='.urlencode($row['nombre_anuncio']).'&foto='.urlencode($row['foto']).'&descripcion='.urlencode($row['descripcion']).'&precio='.urlencode($row['precio']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '"></a>';
                        echo '</div>';
                        echo '<div class="contenedor-anuncio">';
                            echo '<h2>' . $row['nombre_anuncio'] . '</h2>';
                            echo '<p>' . $row['descripcion'] . '</p>';
                            echo '<p class="precio">' . $row['precio'] . '€</p>';
                        echo '</div>';
                        echo '<div class="btn-container">';
                            // Hacemos que al darle al boton de validar salga un modal para asegurarnos
                            echo '<button type="button" name="validar-anuncio" class="btn-validar" data-modal="modalValidarA_' . $row['id_anuncio'] . '">Validar</button>';
                            echo '<div id="modalValidarA_' . $row['id_anuncio'] . '" class="modalValidarA" style="display: none;">';
                                echo '<div class="modal-content">';
                                    echo '<p>¿Está seguro de validar el anuncio?</p>';
                                    // Si le da a cancelar el boton cierra el modal 
                                    echo '<button type="button" class="confirmar-no">Cancelar</button>';
                                    // si le damos a validar se le añade el nombre "validar_anuncio" al boton 
                                    echo '<button id="confirmar-si-validar" name="validar_anuncio" value="' . $row['id_anuncio'] . '">Validar</button>';
                                echo '</div>';
                            echo '</div>';
                            // Hacemos que al darle al boton de eliminar salga un modal para asegurarnos
                            echo '<button type="button" name="eliminar-anuncio" class="btn-eliminar" data-modal="modalEliminarA_' . $row['id_anuncio'] . '">Eliminar</button>';
                            echo '<div id="modalEliminarA_' . $row['id_anuncio'] . '" class="modalEliminarA" style="display: none;">';
                                echo '<div class="modal-content">';
                                    echo '<p>¿Está seguro de eliminar el anuncio?</p>';
                                    // Si le da a cancelar el boton cierra el modal
                                    echo '<button type="button" class="confirmar-no">Cancelar</button>';
                                    // si le damos a eliminar se le añade el nombre "eliminar_anuncio" al boton 
                                    echo '<button id="confirmar-si-eliminar" name="eliminar_anuncio" value="' . $row['id_anuncio'] . '">Eliminar</button>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
                }
            ?>
        </div>
    </section>
    
    <section class="seccion-destacada">
        <div class="seccion-titulo">
            <h1 class="titulo-llamativo">Validación de Noticias</h1>
        </div>
        <div id="noticiasContainer" class="productos">
            <?php
                while ($row = $resultNoticias->fetch(PDO::FETCH_ASSOC)) {
                    $imagenAlt = empty($row['foto']) ? 'Sin Foto' : ucfirst($row['titulo']);
                    $imagenURL = empty($row['foto']) ? 'img/sin-foto.jpg' : 'img/noticias/' . $row['foto'];

                    // Cargamos los campos del anuncio y le añadimos dos botones
                    echo '<form class="producto" method="POST" action="validar.php">';
                        echo '<div class="imagen-producto">';
                            echo '<a href="pagina_noticias.php?titulo='.urlencode($row['titulo']).'&foto='.urlencode($row['foto']).'&categoria='.urlencode($row['categoria']).'&descripcion='.urlencode($row['descripcion']).'"><img src="' . $imagenURL . '" alt="' . htmlspecialchars($imagenAlt) . '" class="imagen-noticia3"></a>';
                        echo '</div>';
                        echo '<div class="contenedor-anuncio">';
                            echo '<h1 style="color: black" class="titulo-noticia3-h1">' . ucfirst($row['categoria']) . '</h1>';
                            echo '<h2 class="titulo-noticia3">' . ucfirst($row['titulo']) . '</h2>';
                        echo '</div>';
                        echo '<div class="btn-container">';
                            // Hacemos que al darle al boton de validar salga un modal para asegurarnos
                            echo '<button type="button" name="validar-noticia" class="btn-validar" data-modal="modalValidarN_' . $row['id_noticia'] . '">Validar</button>';
                            echo '<div id="modalValidarN_' . $row['id_noticia'] . '" class="modalValidarN" style="display: none;">';
                                echo '<div class="modal-content">';
                                    echo '<p>¿Está seguro de validar la noticia?</p>';
                                    // Si le da a cancelar el boton cierra el modal
                                    echo '<button type="button" class="confirmar-no">Cancelar</button>';
                                    // si le damos a validar se le añade el nombre "validar_noticia" al boton 
                                    echo '<button id="confirmar-si-validar" name="validar_noticia" value="' . $row['id_noticia'] . '">Validar</button>';
                                echo '</div>';
                            echo '</div>';
                            // Hacemos que al darle al boton de eliminar salga un modal para asegurarnos
                            echo '<button type="button" name="eliminar-noticia" class="btn-eliminar" data-modal="modalEliminarN_' . $row['id_noticia'] . '">Eliminar</button>';
                            echo '<div id="modalEliminarN_' . $row['id_noticia'] . '" class="modalEliminarN" style="display: none;">';
                                echo '<div class="modal-content">';
                                    echo '<p>¿Está seguro de eliminar la noticia?</p>';
                                    // Si le da a cancelar el boton cierra el modal
                                    echo '<button type="button" class="confirmar-no">Cancelar</button>';                                    
                                    // si le damos a eliminar se le añade el nombre "eliminar_noticia" al boton 
                                    echo '<button id="confirmar-si-eliminar" name="eliminar_noticia" value="' . $row['id_noticia'] . '">Eliminar</button>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
                }
            ?>
        </div>
    </section>

    <script>
        // Creamos las variables que recojen los botones
        const btnValidar = document.getElementsByClassName('btn-validar');
        const btnEliminar = document.getElementsByClassName('btn-eliminar');
        const btnConfirmarNo = document.getElementsByClassName('confirmar-no');

        // Añadimos los eventos a los botones cuando ya se ha cargado la pagina
        for (const btn of btnValidar) {
            btn.addEventListener('click', (e) => {
                const modalId = e.currentTarget.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'block';
                    document.body.classList.add('no-scroll');
                }
            });
        }

        // Añadimos los eventos a los botones cuando ya se ha cargado la pagina
        for (const btn of btnEliminar) {
            btn.addEventListener('click', (e) => {
                const modalId = e.currentTarget.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'block';
                    document.body.classList.add('no-scroll');
                }
            });
        }

        // Añadimos los eventos a los botones cuando ya se ha cargado la pagina
        for (const btn of btnConfirmarNo) {
            btn.addEventListener('click', (e) => {
                const modal = e.target.closest('.modalValidarA, .modalEliminarA, .modalValidarN, .modalEliminarN');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.classList.remove('no-scroll');
                }
            });
        }
    </script>

    <!-- Cargamos el footer mediante php -->
    <?php
        include('footer.php');
    ?>
</body>
</html>
