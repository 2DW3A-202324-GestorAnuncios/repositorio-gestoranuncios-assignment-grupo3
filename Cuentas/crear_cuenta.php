<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Crear Cuenta - CIFP Txurdinaga</title>
</head>
<body> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = mysqli_connect("localhost", "root", "", "gestor_anuncios");
        
        // Comprueba conexion
        if($conn === false){
            die("ERROR: No se ha podido conectar. "
                . mysqli_connect_error());
        }
        
        // Coje los datos del formulario
        $usuario = $_POST['usuario'];
        $nombre =  $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email =  $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $imagen = $_POST['imagen'];
        
        // Inserta los datos a la tabla "usuario"
        mysqli_query($conn,"INSERT INTO usuario (nombre_usuario, nombre, apellido, correo, password, foto) VALUES ('$usuario','$nombre','$apellido','$email','$contraseña','$imagen')");

        // Cierra conexion
        mysqli_close($conn); 
        header("Location: http://localhost/Pagina%20R1/repositorio-gestoranuncios-assignment-grupo3/");
    }
        

    ?>
    <div class="form-crear-cuenta">
        <img src="../img/Logo_Inicio_Sesion.png" alt="logo" class="logo-inicio-sesion">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="id-form">
            <div class="crear-cuenta">
                <div>
                    <p>Nombre:</p>
                    <input type="text" class="input-text" autofocus maxlength="15" name="nombre" id="nombre">
                    <span class="error" id="error6"></span>

                </div>
                <div>
                    <p>Apellido:</p>
                    <input type="text" class="input-text" maxlength="15" name="apellido" id="apellido">
                    <span class="error" id="error7"></span>

                </div>
                <div>
                    <p>Usuario:</p>
                    <input type="text" class="input-text" maxlength="15" name="usuario" id='usuario'>
                    <span class="error" id="error1"></span>
                </div>
                <div>
                    <p>Correo:</p>
                    <input type="mail" class="input-text" name="email" id='email'>
                    <span class="error" id="error2"></span>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <input type="password"  class="input-text" name="contraseña" aria-laballedby="password" id="validar-contraseña">
                    <span class="error" id="error3"></span>
                    <div id="expresiones">

                    </div>
                </div>
                <div>
                    <p>Confirmar contraseña:</p>
                    <input type="password" class="input-text" id="validar-contraseña2">
                    <span class="error" id="error4"></span>

                </div>
            </div>
            <br>
            <div id="imagen">
                <input type="file" accept="image/*" name="imagen">
            </div>
            <div class="terminos-crear-cuenta" >
                <input id="terminos" type="checkbox" name="terminos" class="terminos-checkbox" id="terminos-crear-cuenta" name="terminos" id="terminos" >
                <label class="terminos-checkbox" for="terminos-crear-cuenta">Acepto los terminos y condiciones</label><br>
                <span class="error" id="error5"></span>

            </div>
            <input type="submit" value="Crear Cuenta" name="submit" class="boton">
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