<?php
    try {
        $pdo = new PDO("mysql:host=;dbname=", "root", "");
    } catch (PDOException $e) {
        echo "Error en conectar la base de datos ". $e->getMessage();
    }
?>