<header>
    <a href="index.php">
        <img src="img/Logo_Home3.png" alt="Inicio" height="80px" id="logo">
        <img src="img/logotxur.png" alt="Inicio" height="90px" id="logo2">

    </a>
    <div id="buttons-container">
        <a class="header-buttons" href="crear_noticia.php">
            <img src="img/boton_profesores.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado-header">Crear Noticia</div>
        </a>
        <a class="header-buttons" href="crear_anuncio.php">
            <img src="img/boton_alumnos.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado-header">Crear Anuncio</div>
        </a>
        <a class="header-buttons" href="mi_perfil.php">
            <img src="img/boton_empresas.png" alt="Inicio" width="100px" height="80px">
            <div class="centrado-header">Mi Perfil</div>
        </a>
        <a class="header-buttons" href="carrito_compra.php">
            <img src="img/carrito_compra.png" alt="Inicio" width="50px" height="50px" style="margin-top: 20px;">
        </a>
    </div>
</header>

<div id="pro-menu-principal" class="pro-menu">
    <ul id="menu-principal" class="pro-menu-list">
        <li class="menu-item"><a href="index.php">Inicio</a></li>
        <li class="menu-item"><a href="noticia.php">Noticias</a></li>
        <li class="menu-item"><a href="anuncio.php">Anuncios</a></li>
        <li class="menu-item"><a href="mis_publicaciones.php">Mis Publicaciones</a></li>
        <?php
            // Comprobar si el usuario es administrador y agregar la opción "Validar"
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                echo '<li class="menu-item"><a href="validar.php">Validar</a></li>';
            }
        ?>
        <li class="menu-item"><a href="contacto.php">Contacto</a></li>
    </ul>
</div>
<nav>
    <ul class="navdesp">
        <li><img class="despImg" src="img/desplegable.png" alt="">
            <ul class="coloresDesp">
                <li class="menu-item"><a href="index.php">Inicio</a></li>
                <li class="menu-item"><a href="noticia.php">Noticias</a></li>
                <li class="menu-item"><a href="anuncio.php">Anuncios</a></li>
                <li class="menu-item"><a href="mis_publicaciones.php">Mis Publicaciones</a></li>
                <li class="menu-item"><a href="validar.php">Validar</a></li>

            </ul>
        </li>
    </ul>
</nav>
