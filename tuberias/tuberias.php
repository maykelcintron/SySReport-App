<?php 
    require '../config/pdo.php';
    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
        header('Location: /infraestructura/index.php');
        exit;
    }

    $calle = $pdo->prepare("SELECT * FROM usuarios INNER JOIN reportes WHERE usuarios.cedula = reportes.id_cedula AND reportes.tipo_reporte = 2;");
    $calle->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SySReport</title>
    <link rel="stylesheet" href="../assets/css/reportes.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="shortcut icon" href="../assets/img/icon.svg" type="image/x-icon">
</head>
<body>
    <h1 class="titulo">Reportes</h1>
    
    <?php if($calle->rowCount() == 0): ?>
        <h2 class="none">No hay reportes</h2>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_tuberia'])): ?>
        <p style="margin: 0 auto;" class="error"><?= $_SESSION['error_tuberia'] ?></p>
        <?php unset($_SESSION['error_tuberia']); ?>
    <?php endif; ?>

    <a class="volver" href="/infraestructura/admin.php">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
        </svg>
    </a>
    <a class="agregar" href="agregar-tuberia.php">Agregar</a>

    <table>
        <thead>
            <th>nombre</th>
            <th>apellido</th>
            <th>descripcion</th>
            <th>ubicacion</th>
            <th>fecha</th>
            <th>Acciones</th>
        </thead>
        <tbody>

            
            <?php while($row = $calle->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['nombre']; ?></td>
                    <td><?= $row['apellido']; ?></td>
                    <td><?= $row['descripcion']; ?></td>
                    <td><?= $row['ubicacion']; ?></td>
                    <td><?= $row['fecha']; ?></td>
                    <td>
                        <a class="editar" href="editar-tuberia.php?id=<?= openssl_encrypt($row['id'], AES, KEY)?>">Editar</a>
                        <a class="eliminar" href="eliminar-tuberia.php?id=<?=$row['id']?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </tbody>
    </table>
</body>
</html>