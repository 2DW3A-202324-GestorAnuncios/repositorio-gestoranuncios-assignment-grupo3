<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <script src="../script.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Crear Cuenta - CIFP Txurdinaga</title>
</head>
<body> 
    <?php
        $repeticionPK = "";

        if (mysqli_num_rows($resultUsu) == 0 && mysqli_num_rows($resultCorr) == 0){
            
            if ($c1 === $c2 && !empty($c1) && !empty($c2)) {
                // Coje los datos del formulario
                $usuario = $_POST['usuario'];
                $nombre =  $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $fecha = $_POST['fecha'];
                $genero = $_POST['genero'];
                $email =  $_POST['email'];
                $contraseña = $_POST['contraseña'];
                $imagen = $_POST['imagen'];
                
                // Inserta los datos a la tabla "usuario"
                mysqli_query($conn,"INSERT INTO usuario (nombre_usuario, nombre, apellido,fecha_nac,sexo, correo, password, foto) VALUES ('$usuario','$nombre','$apellido','$fecha','$genero','$email','$contraseña','$imagen')");
    
                // Cierra conexion
                mysqli_close($conn); 
                header("Location: http://localhost/Pagina%20R1/repositorio-gestoranuncios-assignment-grupo3/");
            }else{
                
            }

            $usu = $_POST['usuario'];
            $corr = $_POST['email'];
            $c1 = $_POST['contraseña'];
            $c2 = $_POST['contraseña2'];
            $claveUsu = "SELECT nombre_usuario FROM usuario where nombre_usuario = '" . $usu . "' ";
            $resultUsu = mysqli_query($conn, $claveUsu);
            $claveCorr = "SELECT correo FROM usuario where correo = '" . $corr . "' ";
            $resultCorr = mysqli_query($conn, $claveCorr);

            if (mysqli_num_rows($resultUsu) == 0 && mysqli_num_rows($resultCorr) == 0) {
                if ($c1 === $c2 && !empty($c1) && !empty($c2)) {
                    // Coje los datos del formulario
                    $usuario = $_POST['usuario'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $email = $_POST['email'];
                    $contraseña = $_POST['contraseña'];
                    $imagen = $_POST['imagen'];

                    // Hash de la contraseña
                    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);

                    // Inserta los datos a la tabla "usuario" con la contraseña hasheada
                    mysqli_query($conn, "INSERT INTO usuario (nombre_usuario, nombre, apellido, correo, password, foto) VALUES ('$usuario','$nombre','$apellido','$email','$contraseñaHash','$imagen')");

                    // Cierra conexión
                    mysqli_close($conn);
                    header("Location: http://localhost/Pagina%20R1/repositorio-gestoranuncios-assignment-grupo3/");
                } else {
                    // Manejo de errores
                }
            } else {
                $repeticionPK = "El usuario o correo ya existen";
            }
        }
    ?>
    <div class="form-crear-cuenta">
        <img src="../img/Logo_Inicio_Sesion.png" alt="logo" class="logo-inicio-sesion">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="id-form">
            <div class="crear-cuenta">
                <div>
                    <p>Nombre:</p>
                    <input type="text" class="input-text" autofocus maxlength="15" name="nombre" id="nombre">
                    <span class="error" id="error6" name="error6"></span>

                </div>
                <div>
                    <p>Apellido:</p>
                    <input type="text" class="input-text" maxlength="15" name="apellido" id="apellido">
                    <span class="error" id="error7" name="error7"></span>

                </div>
                <div>
                    <p>Usuario:</p>
                    <input type="text" class="input-text" maxlength="15" name="usuario" id='usuario'>
                    <span class="error" id="error1" name="error1"></span>
                </div>
                <div>
                    <p>Correo:</p>
                    <input type="mail" class="input-text" name="email" id='email'>
                    <span class="error" id="error2" name="error2"></span>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <input type="password"  class="input-text" name="contraseña" aria-laballedby="password" id="validar-contraseña">
                    <span class="error" id="error3" name="error3"></span>
                    <div id="expresiones">

                    </div>
                </div>
                <div>
                    <p>Confirmar contraseña:</p>
                    <input type="password" class="input-text" name="contraseña2" id="validar-contraseña2">
                    <span class="error" id="error4" name="error4"></span>

                </div>
                <div>
                    <p>Fecha de nacimiento:</p>
                    <input type="date" class="input-text" name="fecha" id="fecha">
                    <span class="error" id="error8" name="error8"></span>

                </div>
                <div>
                    <p>Genero:</p>
                    <div class="input-genero">
                        <input type="radio" id="masculino" name="genero" value="masculino">
                        <label for="html">Masculino</label><br>
                        <input type="radio" id="femenino" name="genero" value="femenino">
                        <label for="css">Femenino</label><br>
                        <input type="radio" id="otros" name="genero" value="otros">
                        <label for="css">Otros</label><br>
                    </div>
                    <span class="error" id="error9" name="error9"></span>

                </div>
            </div>
            <br>
            <div id="imagen">
                <p>Foto de perfil(no obligatorio):</p>
                <input type="file" accept="image/*" name="imagen">
            </div><br><br>
            <div class="terminos-crear-cuenta" >
                <input id="terminos" type="checkbox" name="terminos" class="terminos-checkbox" id="terminos-crear-cuenta" name="terminos" id="terminos" >
                <label class="terminos-checkbox" for="terminos-crear-cuenta">Acepto los terminos y condiciones</label><br>
                <span class="error" id="error5" name="error5"></span>
            </div>
            <span id="repPK"><?php echo $repeticionPK ?></span>
            <div class="botones-crear-cuenta">
                <input type="button" value="Volver" class="boton" onclick="location.href='../index.php';">
                <input type="submit" value="Crear Cuenta" name="submit" class="boton" onclick="validarCampos()">
            </div>
        </form>
    </div>
    
    
    <script>
        //para el reenvio del formulario al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }  
        

    </script>
</body>
</html>