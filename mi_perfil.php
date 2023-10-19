<?php
include("conexion.php");

session_start();

$usuario = $_SESSION["usuario"];

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

        // Realiza la actualización en la base de datos
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
    <link rel="shortcut icon" href="img/favicon.png">
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
        <h1>Mi Perfil</h1>

        <div id="datos-modo-visualizacion">
            <p><strong>Nombre Completo:</strong> <?php echo ucwords($nombre) . ' ' . ucwords($apellido); ?></p>
            <p><strong>Fecha Nacimiento:</strong> <?php echo date("d-m-Y", strtotime($fecha_nac)); ?></p>
            <p><strong>Género:</strong> <?php echo $sexo; ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo $correo; ?></p>
            <p><strong>Foto de Perfil:</strong></p>
            <div class="foto-container">
                <img src="img/fotoPerfil/<?php echo empty($foto) ? 'sin-foto-perfil.jpg' : $foto; ?>"
                    alt="Foto de perfil">
            </div>
        </div>

        <button id="editar-datos-btn" name="editar">Editar Datos</button>
        <button id="cerrar-sesion-btn" name="cerrar-sesion">Cerrar Sesión</button>
        <div id="confirmar-cierre" class="modal" style="display: none;">
            <div class="modal-content">
                <p>¿Estás seguro de que deseas cerrar la sesión?</p>
                <button id="confirmar-si">Sí</button>
                <button id="confirmar-no">No</button>
            </div>
        </div>

        <form id="perfilForm" action="mi_perfil.php" method="POST" enctype="multipart/form-data" class="modo-edicion">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>">

            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac"
                value="<?php echo date("Y-m-d", strtotime($fecha_nac)); ?>">

            <label>Género:</label>
            <input type="radio" id="masculino" name="sexo" value="Masculino"
                <?php if ($sexo === 'Masculino') echo 'checked'; ?>>
            <label class="sexo" for="masculino">Masculino</label>
            <input type="radio" id="femenino" name="sexo" value="Femenino"
                <?php if ($sexo === 'Femenino') echo 'checked'; ?>>
            <label class="sexo" for="femenino">Femenino</label>
            <input type="radio" id="otros" name="sexo" value="Otros" <?php if ($sexo === 'Otros') echo 'checked'; ?>>
            <label class="sexo" for="otros">Otros</label>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>">

            <label for="foto">Foto de Perfil:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php if ($modo_edicion) : ?>
            <input type="hidden" name="foto_actual" value="<?php echo $foto; ?>">
            <?php endif; ?>

            <button type="submit" name="guardar">Guardar Cambios</button>
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
        document.body.classList.add('no-scroll'); // Agrega la clase para desactivar el scroll
    });

    confirmarSiBtn.addEventListener('click', () => {
        // Aquí debes agregar la lógica para cerrar la sesión
        // Puedes usar una redirección a la página de cierre de sesión
        window.location.href =
        'Cuentas/cerrar_sesion.php'; // Esto es un ejemplo, asegúrate de ajustar la URL a tu configuración
    });


    confirmarNoBtn.addEventListener('click', () => {
        // Cierra el desplegable y restaura el scroll
        modal.style.display = 'none';
        document.body.classList.remove('no-scroll'); // Quita la clase para restaurar el scroll
    });

    cancelarBtn.addEventListener('click', () => {
        datosModoVisualizacion.style.display = 'block';
        perfilForm.style.display = 'none';
        editarDatosBtn.style.display = 'block';
        cerrarSesionBtn.style.display = 'block';
        cancelarBtn.style.display = 'none';
    });
    </script>



    <?php
        include('footer.php');
    ?>
</body>

</html>