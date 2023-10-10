<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Inicio de Sesión - CIFP Txurdinaga</title>
</head>
<body>
    <div class="form_inicio_sesion">
        <img src="../img/Logo_Inicio_Sesion.png" alt="Logo CIFP Txurdinaga" class="logo_inicio_sesion">
        <form action="" class="inicio_sesion" method="post">
            <p>Usuario o correo:</p>
            <input type="text" class="input_text">
            <p>Contraseña:</p>
            <input type="text" class="input_text">
            <input type="button" value="Iniciar Sesion" class="boton">
        </form>
        <div class="link_crear_cuenta">
            <a href="crear_cuenta.php" class="link_crear_cuenta">Crear Cuenta</a>
        </div>
    </div>
</body>

</html>