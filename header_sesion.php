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
        <a class="header-buttons" href="mi_perfil.php" id="sesion-iniciada-btn">
            <img src="img/boton_empresas.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado">Editar perfil</div>
        </a>
        <a href="Cuentas/cerrar_sesion.php" id="cerrar-sesion-btn">
            <img src="img/cerrar-sesion.jpg" alt="Cerrar Sesión" width="100px" >
        </a>
    </div>
</header>

<div id="pro-menu-principal" class="pro-menu">
    <ul id="menu-principal" class="pro-menu-list">
        <li class="menu-item"><a href="index.php">Inicio</a></li>
        <li class="menu-item"><a href="noticia.php">Noticias</a></li>
        <li class="menu-item"><a href="anuncio.php">Anuncios</a></li>
        <li class="menu-item"><a href="mispublicaciones.php">Mis Publicaciones</a></li>
        <?php
            // Comprobar si el usuario es administrador y agregar la opción "Validar"
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                echo '<li class="menu-item"><a href="validar.php">Validar</a></li>';
            }
        ?>
    </ul>
</div>
