<header>
    <a href="index.php">
        <img src="img/Logo_Home3.png" alt="Inicio" height="80px" id="logo">
    </a>
    <div id="buttons-container">
        <a class="header-buttons" href="crear_noticia.php">
            <img src="img/boton_profesores.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado">Crear Noticia</div>
        </a>
        <a class="header-buttons" href="crear_anuncio.php">
            <img src="img/boton_alumnos.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado">Crear Anuncio</div>
        </a>
        <?php
            echo '
                <div class="header-dropdown" id="iniciar-sesion-dropdown">
                    <a class="header-buttons" href="javascript:void(0)" id="iniciar-sesion-btn">
                        <img src="img/boton_empresas.png" alt="Inicio" width="100px" height="80px">
                        <div class="centrado">Iniciar Sesión</div>
                    </a>
                    <div id="form-inicio-sesion" class="form-sesion">
                        <h2>Iniciar Sesión</h2>
                        <form action="index.php" method="POST">
                            <label for="usuario">Usuario:</label>
                            <input type="text" id="usuario" name="usuario" required>
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" id="contrasena" name="contrasena" required>
                            <button type="submit">Iniciar Sesión</button>
                            <div class="registrarseContainer">
                                <div id="textRegistrarse">¿No tienes cuenta? </div>
                                <a href="Cuentas/crear_cuenta.php" id="btnRegistrarse"><span>Registrarse</span></a>
                            </div>
                        </form>
                    </div>
                </div>
            ';
        ?>
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
    var btnIniciarSesion = document.getElementById("iniciar-sesion-btn");
    var formSesion = document.getElementById("form-inicio-sesion");

    btnIniciarSesion.addEventListener("click", function(event) {
        event.stopPropagation(); // Evita que el clic se propague al contenedor

        if (formSesion.style.display === "none" || formSesion.style.display === "") {
            formSesion.style.display = "block";
        } else {
            formSesion.style.display = "none";
        }
    });

    // Agrega un manejador de eventos al documento para ocultar el formulario al hacer clic en cualquier otro lugar
    document.addEventListener("click", function() {
        formSesion.style.display = "none";
    });

    // Evita que el clic en el formulario se propague al documento
    formSesion.addEventListener("click", function(event) {
        event.stopPropagation();
    });
</script>
