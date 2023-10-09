<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../script.js"></script>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        $usuErr = $emailErr = $contra1Err = $contra2Err = $termsErr = "";
        $usu = $email = $contra1 = $contra2 = $terms = $action = "";
        
        if (isset($_POST['submit'])) {
            if (empty($_POST["usuario"])) {
                $usuErr = "Introduce un usuario";
                $_SESSION['usu_vacio'] = $usuErr;
            } else {
                $usu = test_input($_POST["usuario"]);
                if (!preg_match("/^[a-zA-Z0-9]*$/",$usu)) {
                $usuErr = "Introduce solo letras y numeros";
                }
            }
            
            if (empty($_POST["email"])) {
                $emailErr = "Introduce un email";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Formato de email incorrecto";
                }
            }
                
            if (empty($_POST["contraseña1"])) {
                $contra1Err = "Introduce una contraseña";
            } else {
                $contra1 = test_input($_POST["contraseña1"]);
            }
            if (($_POST["contraseña1"])!=($_POST["contraseña2"])) {
                $contra2Err = "Las contraseñas no coinciden";
            }else{
                $contr2 = test_input($_POST["contraseña2"]);

            }
            if (empty($_POST["contraseña2"])) {
                $contra2Err = "Confirma la contraseña";
            }

            if (!isset($_POST["terminos"])) {
                $termsErr = "Debe aceptar los terminos y condiciones";
            } else {
                $terms = test_input($_POST["terminos"]);
                $termsErr = "";

            }

        }

        function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        
        if($usuErr="" && $emailErr="" && $contra1Err="" && $contra2Err="" && $termsErr=""){

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "myDBPDO";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO info (nombre, email, contraseña)
                VALUES ('$nom', '$email', '$contra1')";
                $conn->exec($sql);
                echo "Success! Form Submitted!";
            }
            catch(PDOException $e){
                echo $sql . "<br>" . $e->getMessage();
            }

        $conn = null;
        }
    }
    ?>
    <div class="form_crear_cuenta">
        <img src="../imagenes/logo.png" alt="logo" class="logo_inicio_sesion">
        <form onsubmit="validarContraseña()" action=""  method="post" >
            <div class="crear_cuenta">
                <div>
                    <p>Usuario:</p>
                    <input type="text" class="input_text" autofocus maxlength="15" value="<?php echo $usu;?>" name="usuario"><br>
                    <span class="error"> <?php if(isset($_SESSION['usu_vacio'])){echo $_SESSION['usu_vacio'];unset($_SESSION['usu_vacio']);}?></span>
                </div>
                <div>
                    <p>Correo:</p>
                    <input type="mail" class="input_text" value="<?php echo $email;?>" name="email"><br>
                    <span class="error"> <?php echo $emailErr;?></span>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <input type="text" class="input_text" name="contraseña1" value="<?php echo $contra1;?>" name="contraseña1" aria-laballedby="password" id="validar_contraseña">
                    <span class="error"> <?php echo $contra1Err;?></span>
                    <div id="expresiones">

                    </div>
                </div>
                <div>
                    <p>Confirmar contraseña:</p>
                    <input type="text" class="input_text" name="contraseña2" value="<?php echo $contra2;?>" name="cotnraseña2"><br>
                    <span class="error"> <?php echo $contra2Err;?></span>

                </div>
            </div>
            <br>
            <div class="terminos_crear_cuenta">
                <input type="checkbox" name="terminos" class="terminos_checkbox" id="terminos_crear_cuenta" value="<?php echo $terms;?>" name="terminos">
                <label class="terminos_checkbox" for="terminos_crear_cuenta">Acepto los terminos y condiciones</label><br><br>
                <span class="error"> <?php echo $termsErr;?></span>

            </div>
            <button type="submit" value="Crear Cuenta" name="submit" class="boton">Crear Cuenta</button>

            </form>
    </div>
    
    <script>
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>