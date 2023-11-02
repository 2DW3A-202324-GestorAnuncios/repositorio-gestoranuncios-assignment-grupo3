<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="style" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/fuentes.css">
    <link rel="stylesheet" href="hojaEstilos/estilos.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="img/favicon.png">
    <script src="script.js"></script>
    <title>Crear Cuenta - CIFP Txurdinaga</title>
</head>
<body>
    <!-- Cargamos el header dependiendo de si la sesion esta iniciada utilizando php -->
    <?php
        // Comprobamos que la session este iniciada y que no este vacia
        include('header_no_sesion.php');

        // Incluimos la conexion con la base de datos
        include("conexion.php");

        $repeticionPK = ""; // Inicializa la variable de mensaje de error

        // Si se ha enviado el formulario recogemos los datos en variables para hacer las comprovaciones y por consecuente el insert en la base de datos
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usu = $_POST['usuario'];
            $corr = $_POST['email'];
            $c1 = $_POST['contraseña'];
            $c2 = $_POST['contraseña2'];

            $sql = 'SELECT nombre_usuario FROM usuario where nombre_usuario = "' . $usu . '"';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql2 = 'SELECT correo FROM usuario where correo = "' . $corr . '"';
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (($row) == 0 && ($row2) == 0) {
                if ($c1 === $c2 && !empty($c1) && !empty($c2)) {
                    // Coje los datos del formulario
                    $usuario = $_POST['usuario'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $fecha = $_POST['fecha'];
                    $genero = $_POST['genero'];
                    $email = $_POST['email'];
                    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Hashear la contraseña
                    $imagen = $_POST['imagen'];

                    // Inserta los datos en la tabla "usuario"
                    $sql = 'INSERT INTO usuario (nombre_usuario, nombre, apellido, fecha_nac, sexo, correo, password, foto) VALUES ("$usuario","$nombre","$apellido","$fecha","$genero","$email","$contraseña","$imagen")';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Redirige a la página principal al insertar los datos
                    header("Location: index.php");
                } else {
                    // Las contraseñas no coinciden o están en blanco
                    $repeticionPK = "Las contraseñas no coinciden o están en blanco";
                }
            } else {
                $repeticionPK = "El usuario o correo ya existen";
            }
        }
    ?>

    <div class="form-crear-cuenta">
        <h2>Crear Cuenta</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="id-form" class="crear-cuenta">
            <div class="nombre-completo-container">
                <div class="nombre-container">
                    <input type="text" autofocus maxlength="15" name="nombre" id="nombre" placeholder="Nombre *">
                    <span class="error" id="error6" name="error6"></span>
                </div>
                <div class="apellido-container">
                    <input type="text" maxlength="15" name="apellido" id="apellido" placeholder="Apellido *">
                    <span class="error" id="error7" name="error7"></span>
                </div>
            </div>
            <div class="usuario-correo-container">
                <div class="usuario-container">
                    <input type="text" maxlength="15" name="usuario" id="usuario" placeholder="Usuario *">
                    <span class="error" id="error1" name="error1"></span>
                </div>
                <div class="correo-container">
                    <input type="email" name="email" id="email" placeholder="Correo electrónico *">
                    <span class="error" id="error2" name="error2"></span>
                </div>
            </div>
            <div class="contrasenas-container">
                <div class="contrasena-container">
                    <input type="password" name="contraseña" aria-labeledby="password" id="validar-contraseña" placeholder="Contraseña *">
                    <span class="error" id="error3" name="error3"></span>
                    <div id="expresiones"></div>
                </div>
                <div class="confirmar-contrasena-container">
                    <input type="password" name="contraseña2" id="validar-contraseña2" placeholder="Confirmar la contraseña *">
                    <span class="error" id="error4" name="error4"></span>
                </div>
            </div>
            <div class="fecha-genero-container">
                <div class="fecha-container">
                    <label for="fecha">Fecha de nacimiento: *</label>
                    <input type="date" name="fecha" id="fecha">
                    <span class="error" id="error8" name="error8"></span>
                </div>
                <div class="genero-container">
                    <label>Género: *</label>
                    <div class="input-genero">
                        <label class="genero-radio"><input type="radio" id="masculino" name="genero" value="masculino" class="genero-radio">Masculino</label>
                        <label class="genero-radio"><input type="radio" id="femenino" name="genero" value="femenino" class="genero-radio">Femenino</label>
                        <label class="genero-radio"><input type="radio" id="otros" name="genero" value="otros" class="genero-radio">Otros</label>
                    </div>
                    <span class="error" id="error9" name="error9"></span>
                </div>
            </div>
            <div class="imagen-container">
                <label>Foto de perfil(opcional):</label>
                <input type="file" name="imagen" accept="image/*">
            </div>
            <div class="terminos-crear-cuenta">
                <label class="terminos-checkbox" for="terminos"><input id="terminos" type="checkbox" name="terminos" class="terminos-checkbox" id="terminos-crear-cuenta" name="terminos" id="terminos">Acepto los Términos y Condiciones *</label>
                <span class="error" id="error5" name="error5"></span>
            </div>
            <span id="repPK"><?php echo $repeticionPK ?></span>
            <input type="submit" value="Crear Cuenta" name="submit" id="botonSubmit" onclick="validarCampos()">
        </form>
    </div>

    <script>
        // Para que el reenvio del formulario se ejecute al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <br>
    <br>

    <!-- Incluimos el footer mediante php -->
    <?php             
        include("footer.php");
    ?>
</body>
</html>
