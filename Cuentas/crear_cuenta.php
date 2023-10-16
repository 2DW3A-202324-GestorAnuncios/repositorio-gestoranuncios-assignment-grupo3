<!DOCTYPE html>
<html lang="es-Es">
<head>
    <meta charset="UTF-8">
    <script src="../script.js"></script>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.png">
    <title>Creacion de Cuenta - CIFP Txurdinaga</title>
</head>
<body>   
    <div class="form_crear_cuenta">
        <img src="../img/Logo_Inicio_Sesion.png" alt="logo" class="logo_inicio_sesion">
        <form action="../index.php" method="post" id="id_form" >
            <div class="crear_cuenta">
                <div>
                    <p>Nombre:</p>
                    <input type="text" class="input_text" autofocus maxlength="15" name="nombre">
                </div>
                <div>
                    <p>Apellido:</p>
                    <input type="text" class="input_text" maxlength="15" name="apellido">
                </div>
                <div>
                    <p>Usuario:</p>
                    <input type="text" class="input_text" maxlength="15" name="usuario">
                    <span class="error" id="error1"></span>
                </div>
                <div>
                    <p>Correo:</p>
                    <input type="mail" class="input_text" name="email">
                    <span class="error" id="error2"></span>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <input type="password"  class="input_text" name="contraseña" aria-laballedby="password" id="validar_contraseña">
                    <span class="error" id="error3"></span>
                    <div id="expresiones">

                    </div>
                </div>
                <div>
                    <p>Confirmar contraseña:</p>
                    <input type="password" class="input_text" id="validar_contraseña2">
                    <span class="error" id="error4"></span>

                </div>
            </div>
            <br>
            <div id="imagen">
                <input type="file" accept="image/*" name="imagen">
            </div>
            <div class="terminos_crear_cuenta" >
                <input id="terminos" type="checkbox" name="terminos" class="terminos_checkbox" id="terminos_crear_cuenta" name="terminos" id="terminos" >
                <label class="terminos_checkbox" for="terminos_crear_cuenta">Acepto los terminos y condiciones</label><br>
                <span class="error" id="error5"></span>

            </div>
            <button type="submit" value="Crear Cuenta" name="submit" class="boton" id="boton" onclick="validarCampos()">Crear Cuenta</button>

        </form>
            
    </div>
    <?php
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
        $foto = $_POST['foto'];
        
        // Inserta los datos a la tabla "usuario"
        $sql = "INSERT INTO usuario (nombre_usuario, nombre,  apellido, correo, password, foto ) VALUES ('$usuario','$nombre', 
            '$apellido','$email','$contraseña','$foto')";
        
        // Cierra conexion
        mysqli_close($conn);
    ?>
    
    <script>
        //para el reenvio del formulario al recargar la pagina
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }  
        

    </script>
</body>
</html>