<?php 
    require '../config/pdo.php';
    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
        header('Location: /infraestructura/index.php');
        exit;
    }

    //expresion regular para validar la fecha en formato timestamp
    $fechaTimestamp = '/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/';

    if(isset($_POST['id'])){
        $id = openssl_decrypt(htmlspecialchars($_POST['id']), AES, KEY);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $ubicacion = htmlspecialchars($_POST['ubicacion']);
        $fecha = htmlspecialchars($_POST['fecha']);

        if(empty($descripcion) || empty($ubicacion) || empty($fecha)){
            $_SESSION['error_alumbrado'] = 'Todos los campos son obligatorios para actualizar';
            header('Location: /infraestructura/alumbrado/alumbrado.php');
            exit;
        }

        if(!preg_match($fechaTimestamp, $fecha)){
            $_SESSION['error_alumbrado'] = 'La fecha no tiene el formato correcto';
            header('Location: /infraestructura/alumbrado/alumbrado.php');
            exit;
        }

        $actualizarReporte = $pdo->prepare("UPDATE reportes SET tipo_reporte = 3, descripcion = :descripcion, ubicacion = :ubicacion, fecha = :fecha WHERE id = :id");
        $actualizarReporte->bindParam(':descripcion', $descripcion);
        $actualizarReporte->bindParam(':ubicacion', $ubicacion);
        $actualizarReporte->bindParam(':fecha', $fecha);
        $actualizarReporte->bindParam(':id', $id);
        $actualizarReporte->execute();

        header('Location: /infraestructura/alumbrado/alumbrado.php');
        exit;
    }
?>