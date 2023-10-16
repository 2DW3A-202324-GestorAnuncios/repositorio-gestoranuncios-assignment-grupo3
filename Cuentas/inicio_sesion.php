<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Inicio de Sesión - CIFP Txurdinaga</title>
</head>
<body>
    <div class="form-inicio-sesion">
        <img src="../img/Logo_Inicio_Sesion.png" alt="Logo CIFP Txurdinaga" class="logo-inicio-sesion">
        <form action="" class="inicio-sesion" method="post">
            <p>Usuario o correo:</p>
            <input type="text" class="input-text">
            <p>Contraseña:</p>
            <input type="text" class="input-text">
            <input type="button" value="Iniciar Sesion" class="boton">
        </form>
        <div class="link-crear-cuenta">
            <a href="crear_cuenta.php" class="link-crear-cuenta">Crear Cuenta</a>
        </div>
    </div>
</body>

</html>