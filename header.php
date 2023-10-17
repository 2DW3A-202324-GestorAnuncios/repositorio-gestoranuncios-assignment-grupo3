<?php
    session_start(); // Iniciar la sesión si aún no está iniciada

    // Incluir el archivo de conexión
    include('conexion.php');

    $mensaje_error = "";
    
    // Validar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        // Realizar una consulta para verificar las credenciales (ajusta la consulta según tu base de datos)
        $consulta = "SELECT * FROM usuario WHERE nombre_usuario = :usuario AND password = :contrasena";
        $stmt = $conn->prepare($consulta);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // Las credenciales son correctas, inicia la sesión
            $_SESSION["usuario"] = $usuario;
            // Redirige a la página deseada
            header("Location: index.php");
        } else {
            // Las credenciales son incorrectas, muestra un mensaje de error
            $mensaje_error = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    }

    // Define la variable $sesion_iniciada según si el usuario ha iniciado sesión
    $sesion_iniciada = isset($_SESSION["usuario"]);

    // Obtén el tipo de usuario desde la base de datos
    $admin = false; // Inicialmente, asumimos que el usuario no es administrador

    if ($sesion_iniciada) {
        // Solo si la sesión está iniciada, obtén el tipo de usuario de la base de datos
        $usuario = $_SESSION["usuario"];

        $consulta_tipo_usuario = "SELECT tipo_usuario FROM usuario WHERE nombre_usuario = :usuario";
        $stmt_tipo_usuario = $conn->prepare($consulta_tipo_usuario);
        $stmt_tipo_usuario->bindParam(':usuario', $usuario);
        $stmt_tipo_usuario->execute();

        if ($stmt_tipo_usuario->rowCount() == 1) {
            $tipo_usuario = $stmt_tipo_usuario->fetchColumn();
            if ($tipo_usuario === "admin") {
                $admin = true; // El usuario es un administrador
            }
        }
    }
?>

<header>
    <a href="index.php">
        <img src="img/Logo_Home3.png" alt="Inicio" height="80px" id="logo">
    </a>
    <div id="buttons-container">
        <?php if ($sesion_iniciada) { ?>
            <a class="header-buttons" href="crear_noticia.php">
                <img src="img/boton_profesores.png" alt="Inicio" width="100px" height="80px">
                <div class="centrado">Crear Noticia</div>
            </a>
            <a class="header-buttons" href="crear_anuncio.php">
                <img src="img/boton_alumnos.png" alt="Inicio" width="100px" height="80px">
                <div class="centrado">Crear Anuncio</div>
            </a>
            <a class="header-buttons" href="mi_perfil.php" id="sesion-iniciada-btn">
                <img src="img/boton_empresas.png" alt="Inicio" width="100px" height="80px">
                <div class="centrado">Editar perfil</div>
            </a>
            <a class="header-buttons" href="Cuentas/cerrar_sesion.php" id="cerrar-sesion-btn">
                <img src="img/boton_profesores.png" alt="Cerrar Sesión" width="100px" height="80px">
                <div class="centrado">Cerrar Sesión</div>
            </a>
        <?php } else { ?>
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
                    <form action="index.php" method="POST" onsubmit="return validarFormulario(event);">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" required>
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                        <button type="submit">Iniciar Sesión</button>
                        <div class="registrarseContainer">
                            <div id="textRegistrarse">¿No tienes cuenta? </div>
                            <a href="Cuentas/crear_cuenta.php" id="btnRegistrarse"><span>Registrarse</span></a>
                        </div>
                        <?php
                            if (isset($mensaje_error) && !empty($mensaje_error)) {
                                echo '<p class="mensaje-error">' . $mensaje_error . '</p>';
                            }
                        ?>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</header>

<div id="pro-menu-principal" class="pro-menu">
    <ul id="menu-principal" class="pro-menu-list">
        <li class="menu-item"><a href="index.php">Inicio</a></li>
        <li class="menu-item"><a href="noticia.php">Noticias</a></li>
        <li class="menu-item"><a href="anuncio.php">Anuncios</a></li>
        <?php
        if ($sesion_iniciada) {
            echo '<li class="menu-item"><a href="mispublicaciones.php">Mis Publicaciones</a></li>';
        } else {
            echo '<li class="menu-item"><a href="contacto.php">Contacto</a></li>';
        }
        if ($sesion_iniciada && $admin) {
            echo '<li class="menu-item"><a href="validar.php">Validar</a></li>';
        }
        ?>
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

    // function validarFormulario(event) {
    //     var usuarioInput = document.getElementById("usuario");
    //     var contrasenaInput = document.getElementById("contrasena");
    //     var mensajeError = document.getElementById("mensaje-error");

    //     // Realizar la validación en el cliente
    //     if (usuarioInput.value === "" || contrasenaInput.value === "") {
    //         mensajeError.innerText = "Por favor, completa todos los campos.";
    //         event.preventDefault(); // Evitar el envío del formulario
    //         console.log("....");
    //     }
    // }
</script>
