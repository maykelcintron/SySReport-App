<?php 
    require '../config/pdo.php';
    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
        header('Location: /infraestructura/index.php');
        exit;
    }

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $tuberia = $pdo->prepare("DELETE FROM reportes WHERE id = :id");
        $tuberia->bindParam(':id', $id);
        $tuberia->execute();

        header('Location: /infraestructura/alumbrado/alumbrado.php');
        exit;
    }
?>