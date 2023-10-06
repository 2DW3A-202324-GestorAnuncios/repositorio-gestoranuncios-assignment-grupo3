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
    // define variables and set to empty values
    $usuErr = $emailErr = $contra1Err = $contra2Err = $termsErr = "";
    $usu = $email = $contra1 = $contra2 = $terms = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["usuario"])) {
        $usuErr = "Introduce un usuario";
    } else {
        $usu = test_input($_POST["usuario"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z][0-9]*$/",$usu)) {
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
        $contraErr = "Introduce una contraseña";
    } else {
        $contra = test_input($_POST["website"]);
        
    }

    if (($_POST["contraseña1"])!=($_POST["contraseña2"])) {
        $contra2 = "Las contraseñas tienen que ser identicas";
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
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
        <form action="../index.php" class="crear_cuenta" method="post" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
            <div>
                <p>Usuario:</p>
                <input type="text" class="input_text" maxlength="15" value="<?php echo $usu;?>" name="usuario"><br><br>
                <span class="error"> <?php echo $usuErr;?></span>
            </div>
            <div>
                <p>Correo:</p>
                <input type="mail" class="input_text" value="<?php echo $email;?>" name="email"><br><br>
                <span class="error"> <?php echo $emailErr;?></span>
            </div>
            <div>
                <p>Contraseña:</p>
                <input type="text" class="input_text" name="contra1" value="<?php echo $contra1;?>" name="contraseña1"><br><br>
                <span class="error"> <?php echo $contra1Err;?></span>

            </div>
            <div>
                <p>Confirmar contraseña:</p>
                <input type="text" class="input_text" name="contra2" value="<?php echo $contra2;?>" name="cotnraseña2"><br><br>
                <span class="error"> <?php echo $contra2Err;?></span>

            </div>
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