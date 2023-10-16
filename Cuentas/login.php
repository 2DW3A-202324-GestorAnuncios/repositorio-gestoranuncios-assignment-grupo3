<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="../hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="../hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="../hojaEstilos/estilos.css">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Inicio de Sesión - CIFP Txurdinaga</title>
</head>
<body>
    <main>
        <section class="inicio-sesion">
            <h1>Iniciar Sesión</h1>
            <div class="contenido-inicio-sesion">
                <div class="form-inicio-sesion">
                    <form action="procesar_inicio_sesion.php" method="post">
                        <label for="usuario">Usuario o correo:</label>
                        <input type="text" id="usuario" name="usuario" required>
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                        <button type="submit">Iniciar Sesión</button>
                    </form>
                </div>
                <div class="imagen-inicio-sesion">
                <img src="../img/Logo_Inicio_Sesion.png" alt="Logo CIFP Txurdinaga">
                </div>
            </div>
        </section>
    </main>
</body>
</html>
