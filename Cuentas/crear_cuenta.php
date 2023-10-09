<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<header>
    
</header>
<body>
    <?php
    session_start();
    
    $usuErr = $emailErr = $contra1Err = $contra2Err = $termsErr = "";
    $usu = $email = $contra1 = $contra2 = $terms = "";
   

    if (isset($_POST['submit'])) {
    if (empty($_POST["usuario"])) {
        $usuErr = "Introduce un usuario";
        $_SESSION['usu_vacio'] = $usuErr;
    } else {
        $usu = test_input($_POST["usuario"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9]*$/",$usu)) {
        $usuErr = "Introduce solo letras y numeros";
        }
    }
    
    if (empty($_POST["email"])) {
        $emailErr = "Introduce un email";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Formato de email incorrecto";
        }
    }
        
    if (empty($_POST["contraseña1"])) {
        $contra1Err = "Introduce una contraseña";
    } else {
        
    }

    if (($_POST["contraseña1"])!=($_POST["contraseña2"])) {
        $contra2Err = "Las contraseñas no coinciden";
    }

    if (!isset($_POST["terminos"])) {
        $termsErr = "Debe aceptar los terminos y condiciones";
    } else {
        $termsErr = "";
        ;
    }
    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    ?>
    <div class="form_crear_cuenta">
        <img src="../imagenes/logo.png" alt="logo" class="logo_inicio_sesion">
        <form action=""  method="post" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
            <div class="crear_cuenta">
                <div>
                    <p>Usuario:</p>
                    <input type="text" class="input_text" maxlength="15" value="<?php echo $usu;?>" name="usuario"><br>

                    <span class="error"> <?php if(isset($_SESSION['usu_vacio'])){echo $_SESSION['usu_vacio'];unset($_SESSION['usu_vacio']);}?></span>
                </div>
                <div>
                    <p>Correo:</p>
                    <input type="mail" class="input_text" value="<?php echo $email;?>" name="email"><br>
                    <span class="error"> <?php echo $emailErr;?></span>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <input type="text" class="input_text" name="contraseña1" value="<?php echo $contra1;?>" name="contraseña1"><br>
                    <span class="error"> <?php echo $contra1Err;?></span>

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
            <input type="submit" value="Crear Cuenta" name="submit" class="boton">

            </form>
    </div>
    
</body>
</html>