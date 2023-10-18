<?php
    include("conexion.php"); // Incluye el archivo de conexión a la base de datos

    // Inicializa la variable de error como vacía
    $mensaje_error = '';

    // Inicializa la variable para mostrar el formulario como verdadera
    $mostrar_formulario = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validación de campos
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        if (empty($usuario) && empty($contrasena)) {
            $mensaje_error = "Por favor, completa ambos campos.";
            // Establece la variable para mostrar el formulario como verdadera
            $mostrar_formulario = true;
        } elseif (empty($usuario)) {
            $mensaje_error = "El campo de usuario es obligatorio.";
            // Establece la variable para mostrar el formulario como verdadera
            $mostrar_formulario = true;
        } elseif (empty($contrasena)) {
            $mensaje_error = "El campo de contraseña es obligatorio.";
            // Establece la variable para mostrar el formulario como verdadera
            $mostrar_formulario = true;
        } else {
            // Realiza una consulta SQL para verificar las credenciales en la base de datos
            $sql = "SELECT * FROM usuario WHERE nombre_usuario = :usuario and password = :contrasena";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Las credenciales son válidas
                $_SESSION['sesion_iniciada'] = true;
                $_SESSION["usuario"] = $usuario;

                // Verificar si el usuario es administrador
                if ($row['tipo_usuario'] == 'admin') {
                    $_SESSION['admin'] = true;
                }

                header("Location: index.php");
                exit();
            } else {
                // Las credenciales son incorrectas
                $mensaje_error = "El nombre de usuario/contraseña son incorrectas. Inténtalo de nuevo.";
                // Establece la variable para mostrar el formulario como verdadera
                $mostrar_formulario = true;
            }
        }
    }
?>

<header>
    <a href="index.php">
        <img src="img/Logo_Home3.png" alt="Inicio" height="80px" id="logo">
    </a>
    <div id="buttons-container">
        <a class="header-buttons" href="javascript:void(0)" onclick="toggleDropdown()">
            <img src="img/boton_profesores.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado">Crear Noticia</div>
        </a>
        <a class="header-buttons" href="javascript:void(0)" onclick="toggleDropdown()">
            <img src="img/boton_alumnos.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado">Crear Anuncio</div>
        </a>
        <div class="header-dropdown" id="iniciar-sesion-dropdown">
            <a class="header-buttons" href="javascript:void(0)" onclick="toggleDropdown()">
                <img src="img/boton_empresas.png" alt="Inicio" width="100px" height="80px">
                <div class="centrado">Iniciar Sesión</div>
            </a>
            <div id="form-inicio-sesion" class="form-sesion">
                <h2>Iniciar Sesión</h2>
                <form action="index.php" method="POST">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena">
                    <button id="btnIniciarSesion" type="submit">Iniciar Sesión</button>
                    <div class="registrarseContainer">
                        <div id="textRegistrarse">¿No tienes cuenta? </div>
                        <a href="Cuentas/crear_cuenta.php" id="btnRegistrarse"><span>Registrarse</span></a>
                    </div>
                    <div id="mensaje-error" style="display: none;"></div>
                </form>
            </div>
        </div>
    </div>
</header>

<div id="pro-menu-principal" class="pro-menu">
    <ul id="menu-principal" class="pro-menu-list">
        <li class="menu-item"><a href="index.php">Inicio</a></li>
        <li class="menu-item"><a href="noticia.php">Noticias</a></li>
        <li class="menu-item"><a href="anuncio.php">Anuncios</a></li>
        <li class="menu-item"><a href="contacto.php">Contacto</a></li>
    </ul>
</div>

<script>
    function toggleDropdown() {
        var formSesion = document.getElementById("form-inicio-sesion");
        if (formSesion.style.display === "none" || formSesion.style.display === "") {
            formSesion.style.display = "block";
        } else {
            formSesion.style.display = "none";
        }
    }

    // Función para mostrar el mensaje de error
    function mostrarError(mensaje) {
        var mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = mensaje;
        mensajeError.style.display = "block";  // Muestra el mensaje de error
    }

    // Verifica si hay un mensaje de error y lo muestra si es necesario
    <?php
        if (!empty($mensaje_error)) {
            echo 'mostrarError("' . $mensaje_error . '");';
        }
    ?>

    // Verifica si se debe mostrar el formulario
    <?php
        if ($mostrar_formulario) {
            echo 'toggleDropdown();';
        }
    ?>
</script>
