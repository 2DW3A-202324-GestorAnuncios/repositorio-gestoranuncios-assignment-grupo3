<?php
    try {
        $servername = "base-g3.cv2cmtkat6wh.us-east-1.rds.amazonaws.com";
        $username = "admin";
        $password = "123456789";
        $dbname = "gestor_anuncios";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>
