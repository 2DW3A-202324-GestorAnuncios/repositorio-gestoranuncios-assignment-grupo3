<?php
    // Especificamos los ajustes de la base de datos
    // Creamos la conexion y la metemos en una variable en español
    try {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gestor_anuncios";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
    } catch(PDOException $e) {
        // Comprobamos los errores
        echo "Error de conexión: " . $e->getMessage();
    }
?>