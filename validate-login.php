<?php 
    require 'config/pdo.php';
    session_start();

    if(isset($_SESSION['cedula']) || isset($_SESSION['rol'])){
        header('location: report.php');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Cedula no vacia y password
        if(isset($_POST['cedula']) && isset($_POST['password']) && !empty($_POST['cedula'] && !empty($_POST['password']))){
            $cedula = $_POST['cedula'];
            $password = $_POST['password'];
        }else{
            $_SESSION['error'] = "Todos Los campos son obligatorios";
            header('location: login.php');
            exit;
        }
    
        // Longitud de cedula y password
        // if(strlen($cedula) < 7 && (strlen($password) < 8 && strlen($password) > 15)){
        //     $_SESSION['error'] = "La cedula debe tener 7 digitos o 8 ";
        //     $_SESSION['error'] .= "<br>La contraseña debe tener 8 a 15 caracteres";
        //     header('location: login.php');
        //     exit;
        // }else if(strlen($cedula) < 7){
        //     $_SESSION['error'] = "La cedula debe tener 7 digitos o 8";
        //     header('location: login.php');
        //     exit;
        // }else if(strlen($password) < 8 && strlen($password) > 15){
        //     $_SESSION['error'] = "La contraseña debe tener 8 a 15 caracteres";
        //     header('location: login.php');
        //     exit;
        // }
        
        // Verificar si el usuario existe
        $usuario = $pdo->prepare('SELECT * FROM usuarios WHERE cedula = :cedula');
        $usuario->bindParam(':cedula', $cedula);
        $usuario->execute();
        
        if($resultado = $usuario->fetchAll(PDO::FETCH_ASSOC)){
            if(password_verify($password, $resultado[0]['contrasenia'])){
                $resultado[0]['rol'] === 'administrador' ? header('Location: admin.php') : header('Location: report.php');
                
                $_SESSION['rol'] = $resultado[0]['rol'];
                $_SESSION['usuario'] = $resultado[0]['nombre'];
                $_SESSION['cedula'] = $resultado[0]['cedula'];
            }else{
                $_SESSION['error'] = "Contraseña incorrecta";
                header('location: login.php');
            }
        }else{
            $_SESSION['error'] = "Datos incorrectos o Usuario no registrado";
            header('location: login.php');
        }
    }

?>