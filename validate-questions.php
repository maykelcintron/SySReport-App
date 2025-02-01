<?php 
    session_start();
    require 'config/pdo.php';

    if(isset($_SESSION['cedula']) || isset($_SESSION['rol'])){
        header('location: report.php');
        exit();
    }

    if(empty($_POST['cedula']) || empty($_POST['color']) || empty($_POST['artista']) || empty($_POST['deporte'])){
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('location: questions.php');
        exit();
    }

    $resultado = $pdo->prepare("SELECT * FROM preguntas WHERE id_usuario = :cedula" );
    $resultado->bindParam(':cedula', $_POST['cedula']);

    $resultado->execute();

    $preguntas = $resultado->fetchAll(PDO::FETCH_ASSOC);

    if($preguntas){
        if(strtolower($preguntas[0]['respuesta1']) == strtolower($_POST['color']) && strtolower($preguntas[0]['respuesta2']) == strtolower($_POST['artista']) && strtolower($preguntas[0]['respuesta3']) == strtolower($_POST['deporte'])){
            echo strtolower($preguntas[0]['respuesta1']) . " " . strtolower($_POST['color']) . "<br>" . $preguntas[0]['respuesta2'] . " " . $_POST['artista'] . "<br>" . $preguntas[0]['respuesta3'] . " " . $_POST['deporte'];

            $_SESSION['verificar'] = $_POST['cedula'];
            header('Location: reset-password.php');
            exit();
        }else{
            $_SESSION['error'] = "Las respuestas no coinciden";
            header('location: questions.php');
        }
    }else{
        $_SESSION['error'] = "No se encontraron preguntas para este usuario";
        header('location: questions.php');
    }
?>