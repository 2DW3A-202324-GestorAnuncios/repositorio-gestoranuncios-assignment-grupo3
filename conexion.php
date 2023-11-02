<?php
    // Especificamos los ajustes de la base de datos
    // Creamos la conexion y la metemos en una variable en español
    try {
        $hostDB = "gestor-aununcios-g3.cv2cmtkat6wh.us-east-1.rds.amazonaws.com";
        $nombreDB = "gestor_anuncios"
        $usuarioDB = "admin";
        $passwordDB = "123456789";

	$hostPDO = "mysql:host=$hostDB;dbname=nombreDB;charset=utf8mb4";
	$conn = new PDO($hostPDO, $usuarioDB, $passwordDB);
    } catch(PDOException $e) {
        // Comprobamos los errores
        echo "Error de conexión: " . $e->getMessage();
    }
?>
