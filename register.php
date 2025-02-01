<?php
    session_start();

    if(isset($_SESSION['cedula']) || isset($_SESSION['rol'])){
        header('location: report.php');
    }

    if(isset($_SESSION['success'])){
        echo '<p class="success">' . $_SESSION['success'].'</p>';
        session_destroy();
    }

    if(isset($_SESSION['error'])){
        echo '<p class="error">' . $_SESSION['error'].'</p>';
        session_destroy();
    }
?>

<!-- Registro -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SySReport - Register</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="assets/img/icon.svg" type="image/x-icon">
</head>
<body class="body">
    <div class="container">
        <div class="container__logo">
            <svg width="35" height="35" viewBox="0 0 605 605" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8"><path d="M159.333 220.638C159.755 163.053 182.592 107.898 222.999 66.8691H222.925L66.9226 222.872H66.9971C66.4163 223.328 65.8689 223.826 65.3588 224.361C27.4193 262.251 4.41701 312.552 0.573437 366.034C-3.27013 419.516 12.3029 472.59 44.4344 515.516L202.001 357.949L203.639 356.386C174.271 317.277 158.691 269.54 159.333 220.638Z" fill="#0C8C5E"></path><path d="M538.133 382.076C508.275 411.337 470.795 431.62 429.968 440.612C389.141 449.605 346.608 446.944 307.219 432.935C286.219 425.48 266.481 414.857 248.691 401.436L247.052 403.075L89.4863 560.566C132.43 592.618 185.475 608.141 238.922 604.299C292.37 600.457 342.649 577.506 380.567 539.642L382.13 538.078L538.133 382.076Z" fill="#0C8C5E"></path><path d="M604.999 222.871V8.00011C604.999 3.58183 601.417 0.000111522 596.999 0.000111522H382.128C352.857 -0.0292132 323.869 5.72494 296.829 16.932C269.789 28.1391 245.229 44.5783 224.562 65.3052L222.998 66.8689C195.755 94.5256 176.264 128.86 166.479 166.427C184.192 161.841 202.394 159.415 220.689 159.204C269.594 158.629 317.318 174.231 356.438 203.585C391.596 229.805 418.205 265.845 432.912 307.165C447.9 349.397 449.872 395.155 438.572 438.519C476.146 428.751 510.484 409.258 538.13 382.001L539.694 380.512C560.43 359.835 576.874 335.264 588.081 308.21C599.289 281.156 605.038 252.154 604.999 222.871Z" fill="#18E299"></path></svg>
        </div>
        <h2 class="container__title">SySReport</h2>
        <form action="validate-register.php" method="POST">
            <div class="form__label">
                <label for="nombre" class="">Nombre</label>
                <input placeholder="Ingrese su nombre" type="text" id="nombre" name="nombre"  
                class="">
            </div>
            <div class="form__label">
                <label for="apellido" class="">Apellido</label>
                <input placeholder="Ingrese su apellido" type="text" id="apellido" name="apellido"  
                    class="">
            </div>
            <div class="form__label">
                <label for="cedula" class="">Cedula</label>
                <input placeholder="Ingrese su cedula" type="number" id="cedula" name="cedula"  
                    class="">
            </div>
            <div class="form__label">
                <label for="municipio" class="">Municipio</label>
                <input placeholder="Ingrese su municipio" type="text" id="municipio" name="municipio"  
                    class="">
            </div>
            <div class="form__label">
                <label for="dirección" class="">Dirección</label>
                <input placeholder="Ingrese su dirección" type="text" id="dirección" name="dirección"  
                    class="">
            </div>
            <div class="">
                <label for="password" class="">Contraseña</label>
                <input placeholder="Ingrese su contraseña" type="password" id="password" name="password"  
                    class="">
            </div>
            <div class="">
                <label for="confirm-password" class="">Confirmar Contraseña</label>
                <input placeholder="Repita su contraseña" type="password" id="confirm-password" name="confirm-password"  
                    class="">
            </div>
            <hr style="margin: 40px 0;">
            <h2 class="container__title">Preguntas de Seguridad</h2>
            <div style="margin-bottom: 20px;" class="">
                <label for="" class="">1. ¿Qué color le gusta más?</label>
                <input placeholder="Ingrese la respuesta" type="text" id="" name="question1"  
                    class="">
            </div>
            <div style="margin-bottom: 20px;" class="">
                <label for="" class="">2. ¿Cuál es su artista favorito?</label>
                <input placeholder="Ingrese la respuesta" type="text" id="" name="question2"  
                    class="">
            </div>
            <div class="">
                <label for="" class="">3. ¿Qué deporte le gusta más?</label>
                <input placeholder="Ingrese la respuesta" type="text" id="" name="question3"  
                    class="">
            </div>
            <button type="submit" id="button" class="button--register">Registrarme</button>
            <p class="form__paragraph">
                Ya tienes una cuenta
                <a href="login.php">Inicia Sesión</a>
            </p>
        </form>
    </div>
    <script src="assets/js/button.js"></script>
</body>
</html>