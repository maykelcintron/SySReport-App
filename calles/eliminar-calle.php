<?php

    require '../config/pdo.php';
    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
        header('Location: /infraestructura/index.php');
        exit;
    }

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $calle = $pdo->prepare("DELETE FROM reportes WHERE id = :id");
        $calle->bindParam(':id', $id);
        $calle->execute();

        if($calle->rowCount() == 0){
            $_SESSION['error_calle'] = 'La el reporte de calle no se pudo eliminar porque no existe';
        }

        header('Location: /infraestructura/calles/calles.php');
        exit;
    }

?>