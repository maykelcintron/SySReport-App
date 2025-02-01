<?php
    require 'config/pdo.php';
    session_start();

    if(!isset($_SESSION['cedula']) || !isset($_SESSION['rol'])){
        header('location: login.php');
    }

    function validarCampos(): bool{
        if(empty($_POST['category']) || empty($_POST['description']) || empty($_POST['location'])){
            return true;
        }
        return false;
    }

    function registrarReporte($pdo, $tipo_reporte, $descripcion, $ubicacion): void{
        try{
            $reporte = $pdo->prepare("INSERT INTO reportes(id_cedula, tipo_reporte, descripcion, ubicacion) VALUES (:cedula, :tipo_reporte, :descripcion, :ubicacion);");
            $reporte->bindParam(':cedula', $_SESSION['cedula']);
            $reporte->bindParam(':tipo_reporte', $tipo_reporte);
            $reporte->bindParam(':descripcion', $descripcion);
            $reporte->bindParam(':ubicacion', $ubicacion);
    
            $reporte->execute();
            
            $_SESSION["success"] = "Se registro correctamente el reporte";
            header('location: report.php');
        }catch(PDOException $e){
            echo "No se pudo registrar el reporte";
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(validarCampos()){
            $_SESSION["error"] = "Todos los campos son obligatorios";
            header('location: report.php');
            return;
        }

        $categoria = htmlspecialchars($_POST['category']);
        $descripcion = htmlspecialchars($_POST['description']);
        $ubicacion = htmlspecialchars($_POST['location']);

        if($categoria == 'Calle'){
            registrarReporte($pdo, 1, $descripcion, $ubicacion);
        }else if($categoria == 'Tuberia'){
            registrarReporte($pdo, 2, $descripcion, $ubicacion);
        }else if($categoria == 'Alumbrado'){
            registrarReporte($pdo, 3, $descripcion, $ubicacion);
        }
    }