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
    <title>Contacto - CIFP Txurdinaga</title>
</head>

<body>
    <?php
        // Inicia la sesión en la página
        session_start();

        if (isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] === true) {
            include('header_sesion.php');
            // Comprobar si el usuario es administrador
            $admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
        } else {
            include('header_no_sesion.php');
        }
    ?>

    <main>
        <section class="nuestroContacto">
            <h1>Contacto</h1>
            <p>
                ¡Estamos encantados de saber de ti! Puedes contactarnos de las
                siguientes maneras:
            </p>
            <div class="informacion-contacto">
                <h2>Dirección:</h2>
                <p>C/ Doctor Ornilla 2<br>48004 Bilbao</p>
            </div>
            <div class="informacion-contacto">
                <h2>Teléfono:</h2>
                <p>+34 94 412 57 12</p>
            </div>
            <div class="informacion-contacto">
                <h2>Correo Electrónico:</h2>
                <p>
                    <a href="mailto:idazkaria@fpTXurdinaga.com">idazkaria@fpTXurdinaga.com</a>
                </p>
            </div>
            <div class="formulario-contacto">
                <h2>Envíanos un mensaje:</h2>
                <form action="procesar_formulario.php" method="post">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre" required><br>
                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" required><br>
                    <label for="mensaje">Mensaje:</label><br>
                    <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </section>
    </main>

    <?php
        include('footer.php');
    ?>
</body>

</html>