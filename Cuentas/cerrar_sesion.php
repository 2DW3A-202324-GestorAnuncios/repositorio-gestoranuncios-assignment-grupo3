<?php
    session_start(); // Inicia la sesión si no está iniciada
    session_destroy(); // Destruye la sesión actual
    header("Location: ../index.php"); // Redirige al usuario a la página de inicio o a donde desees después de cerrar sesión
?>
