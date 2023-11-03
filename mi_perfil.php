<?php
    include("conexion.php");

    // Inicia la sesión en la página
    session_start();

    $usuario = $_SESSION['usuarioLogin'];
    $tipo_usuario = $_SESSION['admin'];

    $mensaje_exito = '';
    $mensaje_error = '';
    $modo_edicion = false;

    // Obtener los datos del usuario desde la base de datos
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre_usuario', $usuario);
    $stmt->execute();
    $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario_data) {
        // Datos del usuario obtenidos con éxito
        $nombre = $usuario_data['nombre'];
        $apellido = $usuario_data['apellido'];
        $fecha_nac = $usuario_data['fecha_nac'];
        $sexo = $usuario_data['sexo'];
        $correo = $usuario_data['correo'];
        $foto = $usuario_data['foto'];
    } else {
        // Manejar el caso en el que no se encuentren los datos del usuario
        $mensaje_error = "No se pudieron recuperar los datos del usuario.";
    }

    if ($tipo_usuario == 1) {
        $tipo_usuario = "Administrador";
    } else if ($tipo_usuario == 0) {
        $tipo_usuario = "Usuario";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['editar'])) {
            // Cambiar al modo de edición
            $modo_edicion = true;
        } elseif (isset($_POST['guardar'])) {
            // Modo de guardado, actualiza los datos
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $fecha_nac = $_POST['fecha_nac'];
            $sexo = $_POST['sexo'];
            $correo = $_POST['correo'];
            $contrasena_actual = $_POST['contrasena-actual'];
            $nueva_contrasena = $_POST['nueva-contrasena'];
            $confirmar_contrasena = $_POST['confirmar-contrasena'];
            $terminos = isset($_POST['terminos']) ? $_POST['terminos'] : false;

            // Realiza la validación de campos
            $errores = array();

            // Validación del campo de nombre (no vacío y solo letras)
            if (empty($nombre)) {
                $errores['nombre'] = "El campo Nombre es obligatorio.";
            } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)) {
                $errores['nombre'] = "El campo Nombre solo debe contener letras y espacios.";
            }

            // Validación del campo de apellido (no vacío y solo letras)
            if (empty($apellido)) {
                $errores['apellido'] = "El campo Apellido es obligatorio.";
            } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $apellido)) {
                $errores['apellido'] = "El campo Apellido solo debe contener letras y espacios.";
            }

            if (empty($fecha_nac)) {
                $errores['fecha_nac'] = "El campo Fecha de Nacimiento es obligatorio.";
            } else {
                $fecha_actual = new DateTime();
                $fecha_nacimiento = new DateTime($fecha_nac);
                $edad = $fecha_actual->diff($fecha_nacimiento)->y;
                if ($edad < 18) {
                    $errores['fecha_nac'] = "Debes ser mayor de 18 años.";
                }
            }

            // Validación del campo de género (debe estar seleccionado)
            if (empty($sexo)) {
                $errores['sexo'] = "Debes seleccionar un género.";
            }

            // Validación del campo de correo electrónico (formato válido)
            if (empty($correo)) {
                $errores['correo'] = "El campo Correo Electrónico es obligatorio.";
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $errores['correo'] = "El campo Correo Electrónico no tiene un formato válido.";
            }

            if ($terminos) {
                // Validación de la contraseña actual (coincidencia con la contraseña actual)
                if (empty($contrasena_actual)) {
                    $errores['contrasena-actual'] = "El campo Contraseña Actual es obligatorio.";
                } else {
                    $sql = "SELECT password FROM usuario WHERE nombre_usuario = :nombre_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':nombre_usuario', $usuario);
                    $stmt->execute();
                    $contrasena_hash = $stmt->fetchColumn();

                    if (empty($contrasena_hash) || !password_verify($contrasena_actual, $contrasena_hash)) {
                        $errores['contrasena-actual'] = "La contraseña actual es incorrecta.";
                    } else {
                        // La contraseña actual es correcta
                        // Validación de las contraseñas nuevas
                        if (empty($nueva_contrasena)) {
                            $errores['nueva-contrasena'] = "El campo Nueva Contraseña es obligatorio.";
                        } elseif (strlen($nueva_contrasena) < 6) {
                            $errores['nueva-contrasena'] = "La nueva contraseña debe tener al menos 6 caracteres.";
                        }
                        
                        if ($nueva_contrasena !== $confirmar_contrasena) {
                            $errores['confirmar-contrasena'] = "La confirmación de contraseña no coincide con la nueva contraseña.";
                        }
                    }
                }
            } elseif ($terminos && (empty($contrasena_actual) || empty($nueva_contrasena) || empty($confirmar_contrasena))) {
                $errores['terminos'] = "Debes aceptar los términos y condiciones.";
            } elseif (!$terminos && (!empty($contrasena_actual) || !empty($nueva_contrasena) || !empty($confirmar_contrasena))) {
                $errores['terminos'] = "Debes aceptar los términos y condiciones.";
            }

            if (empty($errores)) {
                // Comprueba si se seleccionó un archivo nuevo
                if (!empty($_FILES['foto']['name'])) {
                    // Se seleccionó un archivo nuevo, procesa la subida
                    $foto = $_FILES['foto']['name'];
                    $foto_temp = $_FILES['foto']['tmp_name'];
    
                    // Mueve el archivo temporal al directorio de fotos
                    move_uploaded_file($foto_temp, 'img/fotoPerfil/' . $foto);
                }
    
                // Si no se selecciona un archivo nuevo, se mantiene la foto actual
                if (empty($foto) && isset($_POST['foto_actual'])) {
                    $foto = $_POST['foto_actual'];
                }

                // Si la contraseña nueva y la confirmación coinciden, actualiza la contraseña
                if (!empty($nueva_contrasena) && $nueva_contrasena === $confirmar_contrasena) {
                    $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                    $sql = "UPDATE usuario SET password = :password WHERE nombre_usuario = :nombre_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':password', $nueva_contrasena_hash);
                    $stmt->bindParam(':nombre_usuario', $usuario);
                    $stmt->execute();
                }

                $sql = "UPDATE usuario SET nombre = :nombre, apellido = :apellido, fecha_nac = :fecha_nac, sexo = :sexo, correo = :correo, foto = :foto WHERE nombre_usuario = :nombre_usuario";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellido', $apellido);
                $stmt->bindParam(':fecha_nac', $fecha_nac);
                $stmt->bindParam(':sexo', $sexo);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':foto', $foto);
                $stmt->bindParam(':nombre_usuario', $usuario);

                if ($stmt->execute()) {
                    $mensaje_exito = "Tus datos se han actualizado exitosamente.";
                    // Cambia de nuevo al modo de visualización después de guardar
                    $modo_edicion = false;
                } else {
                    $mensaje_error = "Hubo un error al actualizar tus datos. Inténtalo de nuevo.";
                }
            } else {
                // Se encontraron errores en los campos, mantén el modo de edición activado
                $mensaje_error = "Se encontraron errores en los campos.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es-Es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preload" as="style" href="hojaEstilos/fuentes.css">
<link rel="stylesheet" href="hojaEstilos/fuentes.css">
<link rel="stylesheet" href="hojaEstilos/estilos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="shortcut icon" href="img/favicon.png">
<script src="script.js"></script>
<title>Mi Perfil - CIFP Txurdinaga</title>
</head>
<body>
    <?php
        include('header_sesion.php');

        if (!empty($mensaje_exito)) {
            echo '<div class="mensaje-exito">';
            echo '<p><strong>Éxito!</strong> ' . $mensaje_exito . '</p>';
            echo '</div>';
        } elseif (!empty($mensaje_error)) {
            echo '<div class="mensaje-error">';
            echo '<p><strong>Error!</strong> ' . $mensaje_error . '</p>';
            echo '</div>';
        }
    ?>

    <div class="mi-perfil-container">
        <h1>Mi Perfil - <?php echo $tipo_usuario; ?></h1>

        <div id="datos-modo-visualizacion">
            <p><strong>Nombre Completo:</strong> <?php echo ucwords($nombre) . ' ' . ucwords($apellido); ?></p>
            <p><strong>Fecha Nacimiento:</strong> <?php echo date("d-m-Y", strtotime($fecha_nac)); ?></p>
            <p><strong>Género:</strong> <?php echo $sexo; ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo $correo; ?></p>
            <p><strong>Foto de Perfil:</strong></p>
            <div class="foto-container">
                <img src="img/fotoPerfil/<?php echo empty($foto) ? 'sin-foto-perfil.jpg' : $foto; ?>" alt="Foto de perfil">
            </div>
        </div>

        <button id="editar-datos-btn" name="editar">Editar Datos</button>
        <button id="cerrar-sesion-btn" name="cerrar-sesion">Cerrar Sesión</button>
        <div id="confirmar-cierre" class="modal" style="display: none;">
            <div class="modal-content">
                <p>¿Estás seguro de que deseas cerrar la sesión?</p>
                <button id="confirmar-no">No</button>
                <button id="confirmar-si">Sí</button>
            </div>
        </div>

        <form id="perfilForm" action="mi_perfil.php" method="POST" enctype="multipart/form-data" class="modo-edicion">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" <?php if(isset($errores['nombre'])) echo 'class="error-mi-perfil-input"'; ?>>
            <?php if(isset($errores['nombre'])) echo '<span class="error-mi-perfil">' . $errores['nombre'] . '</span>'; ?>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" <?php if(isset($errores['apellido'])) echo 'class="error-mi-perfil-input"'; ?>>
            <?php if(isset($errores['apellido'])) echo '<span class="error-mi-perfil">' . $errores['apellido'] . '</span>'; ?>

            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo date("Y-m-d", strtotime($fecha_nac)); ?>" <?php if(isset($errores['fecha_nac'])) echo 'class="error-mi-perfil-input"'; ?>>
            <?php if(isset($errores['fecha_nac'])) echo '<span class="error-mi-perfil">' . $errores['fecha_nac'] . '</span>'; ?>

            <label>Género:</label>
            <input type="radio" id="masculino" name="sexo" value="Masculino" <?php if ($sexo === 'Masculino') echo 'checked'; ?>>
            <label class="sexo" for="masculino">Masculino</label>
            <input type="radio" id="femenino" name="sexo" value="Femenino" <?php if ($sexo === 'Femenino') echo 'checked'; ?>>
            <label class="sexo" for="femenino">Femenino</label>
            <input type="radio" id="otros" name="sexo" value="Otros" <?php if ($sexo === 'Otros') echo 'checked'; ?>>
            <label class="sexo" for="otros">Otros</label>
            <?php if(isset($errores['sexo'])) echo '<span class="error-mi-perfil">' . $errores['sexo'] . '</span>'; ?>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" <?php if(isset($errores['correo'])) echo 'class="error-mi-perfil-input"'; ?>>
            <?php if(isset($errores['correo'])) echo '<span class="error-mi-perfil">' . $errores['correo'] . '</span>'; ?>

            <label for="foto">Foto de Perfil:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php if ($modo_edicion) : ?>
                <input type="hidden" name="foto_actual" value="<?php echo $foto; ?>">
            <?php endif; ?>

            <div id="cambiar-contrasena-btn" class="cambiar-contrasena-btn" name="cambiar-contrasena-btn">
                Cambiar Contraseña (Opcional) <i class="fas fa-chevron-down"></i>
            </div>
            <div id="contrasena-form" class="contrasena-form" style="display: none;">
                <label for="contrasena-actual">Contraseña Actual: *</label>
                <div class="password-input-container">
                    <input type="password" id="contrasena-actual" name="contrasena-actual">
                    <i class="fas fa-eye show-password" id="show-contrasena-actual" title="Mostrar contraseña"></i>
                    <i class="fas fa-eye-slash hide-password" id="hide-contrasena-actual" style="display: none;" title="Ocultar contraseña"></i>
                </div>
                <?php if(isset($errores['contrasena-actual'])) echo '<span class="error-mi-perfil">' . $errores['contrasena-actual'] . '</span>'; ?>
                
                <label for="nueva-contrasena">Nueva Contraseña: *</label>
                <div class="password-input-container">
                    <input type="password" id="nueva-contrasena" name="nueva-contrasena">
                    <i class="fas fa-eye show-password" id="show-nueva-contrasena" title="Mostrar contraseña"></i>
                    <i class="fas fa-eye-slash hide-password" id="hide-nueva-contrasena" style="display: none;" title="Ocultar contraseña"></i>
                </div>
                <?php if(isset($errores['nueva-contrasena'])) echo '<span class="error-mi-perfil">' . $errores['nueva-contrasena'] . '</span>'; ?>

                <label for="confirmar-contrasena">Confirmar Contraseña: *</label>
                <div class="password-input-container">
                    <input type="password" id="confirmar-contrasena" name="confirmar-contrasena">
                    <i class="fas fa-eye show-password" id="show-confirmar-contrasena" title="Mostrar contraseña"></i>
                    <i class="fas fa-eye-slash hide-password" id="hide-confirmar-contrasena" style="display: none;" title="Ocultar contraseña"></i>
                </div>
                <?php if(isset($errores['confirmar-contrasena'])) echo '<span class="error-mi-perfil">' . $errores['confirmar-contrasena'] . '</span>'; ?>
                <div class="terminos-crear-cuenta">
                    <label class="terminos-checkbox" for="terminos"><input id="terminos" type="checkbox" name="terminos" class="terminos-checkbox" id="terminos-crear-cuenta" name="terminos" id="terminos">Acepto los Términos y Condiciones *</label>
                    <?php if(isset($errores['terminos'])) echo '<span class="error-mi-perfil">' . $errores['terminos'] . '</span>'; ?>
                </div>
            </div>
            <button id="guardar-btn" type="submit" name="guardar">Guardar Cambios</button>
            <button id="cancelar-btn" name="cancelar">Cancelar</button>
        </form>
    </div>

    <script>
        // JavaScript para cambiar entre el modo de visualización y el modo de edición
        const editarDatosBtn = document.getElementById('editar-datos-btn');
        const datosModoVisualizacion = document.getElementById('datos-modo-visualizacion');
        const perfilForm = document.getElementById('perfilForm');
        const cancelarBtn = document.getElementById('cancelar-btn');
        const cerrarSesionBtn = document.getElementById('cerrar-sesion-btn');
        const modal = document.querySelector('.modal');
        const confirmarSiBtn = document.getElementById('confirmar-si');
        const confirmarNoBtn = document.getElementById('confirmar-no');

        editarDatosBtn.addEventListener('click', () => {
            datosModoVisualizacion.style.display = 'none';
            perfilForm.style.display = 'block';
            editarDatosBtn.style.display = 'none';
            cerrarSesionBtn.style.display = 'none';
            cancelarBtn.style.display = 'inline-block';
        });

        cerrarSesionBtn.addEventListener('click', () => {
            // Muestra el desplegable
            modal.style.display = 'block';
            document.body.classList.add('no-scroll');
        });

        confirmarSiBtn.addEventListener('click', () => {
            // Aquí debes agregar la lógica para cerrar la sesión
            // Puedes usar una redirección a la página de cierre de sesión
            window.location.href = 'Cuentas/cerrar_sesion.php';
        });

        confirmarNoBtn.addEventListener('click', () => {
            // Cierra el desplegable y restaura el scroll
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
        });

        cancelarBtn.addEventListener('click', () => {
            datosModoVisualizacion.style.display = 'block';
            perfilForm.style.display = 'none';
            editarDatosBtn.style.display = 'inline-block';
            cerrarSesionBtn.style.display = 'inline-block';
            cancelarBtn.style.display = 'none';
        });

        // JavaScript para cambiar entre el modo de visualización y el modo de edición
        const cambiarContrasenaBtn = document.getElementById('cambiar-contrasena-btn');
        const contrasenaForm = document.getElementById('contrasena-form');
        const contrasenaActualInput = document.getElementById('contrasena-actual');
        const nuevaContrasenaInput = document.getElementById('nueva-contrasena');
        const confirmarContrasenaInput = document.getElementById('confirmar-contrasena');
        const terminosCheckbox = document.getElementById('terminos');

        cambiarContrasenaBtn.addEventListener('click', () => {
            // Mostrar u ocultar el formulario de contraseña
            if (contrasenaForm.style.display === 'none') {
                contrasenaForm.style.display = 'block';
            } else {
                contrasenaForm.style.display = 'none';
            }
        });

        const showActualContrasena = document.getElementById('show-contrasena-actual');
        const hideActualContrasena = document.getElementById('hide-contrasena-actual');
        const showNuevaContrasena = document.getElementById('show-nueva-contrasena');
        const hideNuevaContrasena = document.getElementById('hide-nueva-contrasena');
        const showConfirmarContrasena = document.getElementById('show-confirmar-contrasena');
        const hideConfirmarContrasena = document.getElementById('hide-confirmar-contrasena');

        showActualContrasena.addEventListener('click', () => {
            contrasenaActualInput.type = 'text';
            showActualContrasena.style.display = 'none';
            hideActualContrasena.style.display = 'inline-block';
        });

        hideActualContrasena.addEventListener('click', () => {
            contrasenaActualInput.type = 'password';
            hideActualContrasena.style.display = 'none';
            showActualContrasena.style.display = 'inline-block';
        });

        showNuevaContrasena.addEventListener('click', () => {
            nuevaContrasenaInput.type = 'text';
            showNuevaContrasena.style.display = 'none';
            hideNuevaContrasena.style.display = 'inline-block';
        });

        hideNuevaContrasena.addEventListener('click', () => {
            nuevaContrasenaInput.type = 'password';
            hideNuevaContrasena.style.display = 'none';
            showNuevaContrasena.style.display = 'inline-block';
        });

        showConfirmarContrasena.addEventListener('click', () => {
            confirmarContrasenaInput.type = 'text';
            showConfirmarContrasena.style.display = 'none';
            hideConfirmarContrasena.style.display = 'inline-block';
        });

        hideConfirmarContrasena.addEventListener('click', () => {
            confirmarContrasenaInput.type = 'password';
            hideConfirmarContrasena.style.display = 'none';
            showConfirmarContrasena.style.display = 'inline-block';
        });
        
        // Verifica si hay errores en los campos
        const hayErrores = <?php echo !empty($errores) ? 'true' : 'false'; ?>;

        // Verifica si hay errores en los campos de contraseña
        const hayErroresContrasena = <?php echo !empty($errores['contrasena-actual']) || !empty($errores['nueva-contrasena']) || !empty($errores['confirmar-contrasena']) || !empty($errores['terminos']) ? 'true' : 'false'; ?>;
        
        // Función para cambiar entre el modo de visualización y el modo de edición
        const cambiarModo = () => {
            if (hayErrores && hayErroresContrasena) {
                datosModoVisualizacion.style.display = 'none';
                perfilForm.style.display = 'block';
                editarDatosBtn.style.display = 'none';
                cerrarSesionBtn.style.display = 'none';
                cambiarContrasenaBtn.click();
            } else if (hayErrores) {
                datosModoVisualizacion.style.display = 'none';
                perfilForm.style.display = 'block';
                editarDatosBtn.style.display = 'none';
                cerrarSesionBtn.style.display = 'none';
            } else if (hayErroresContrasena) {
                datosModoVisualizacion.style.display = 'none';
                perfilForm.style.display = 'block';
                editarDatosBtn.style.display = 'none';
                cerrarSesionBtn.style.display = 'none';
                cambiarContrasenaBtn.click();
            } else {
                datosModoVisualizacion.style.display = 'block';
                perfilForm.style.display = 'none';
                editarDatosBtn.style.display = 'inline-block';
                cerrarSesionBtn.style.display = 'inline-block';
            }
        };
        
        // Ejecuta la función al cargar la página
        window.addEventListener('load', cambiarModo);
    </script>

    <?php
        include('footer.php');
    ?>
</body>
</html>
