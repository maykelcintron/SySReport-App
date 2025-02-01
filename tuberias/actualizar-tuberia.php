<?php 

    require '../config/pdo.php';
    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
        header('Location: /infraestructura/index.php');
        exit;
    }

     //expresion regular para validar la fecha en formato timestamp
    $fechaTimestamp = '/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/';

    $id = openssl_decrypt(htmlspecialchars($_POST['id']), AES, KEY);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $ubicacion = htmlspecialchars($_POST['ubicacion']);
    $fecha = htmlspecialchars($_POST['fecha']);

    if(empty($descripcion) || empty($ubicacion) || empty($fecha)){
        $_SESSION['error_tuberia'] = 'Todos los campos son obligatorios para actualizar un reporte';
        header('Location: /infraestructura/tuberias/tuberias.php');
        exit;
    }

    if(!preg_match($fechaTimestamp, $fecha)){
        $_SESSION['error_tuberia'] = 'La fecha no tiene el formato correcto';
        header('Location: /infraestructura/tuberias/tuberias.php');
        exit;
    }

    $tuberia = $pdo->prepare("UPDATE reportes SET descripcion = :descripcion, ubicacion = :ubicacion, fecha = :fecha WHERE id = :id;");
    $tuberia->bindParam(':id', $id);
    $tuberia->bindParam(':descripcion', $descripcion);
    $tuberia->bindParam(':ubicacion', $ubicacion);
    $tuberia->bindParam(':fecha', $fecha);
    $tuberia->execute();

    header('Location: /infraestructura/tuberias/tuberias.php');
    exit;
?>