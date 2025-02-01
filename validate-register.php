<?php
    require 'config/pdo.php';
    session_start();

    if(isset($_SESSION['cedula']) || isset($_SESSION['rol'])){
        header('location: report.php');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Metodo para verificar si no estan vacios los campos
        $no_empty = !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && 
                    !empty($_POST["cedula"]) && !empty($_POST["municipio"]) && 
                    !empty($_POST["dirección"]) && !empty($_POST["password"]) && 
                    !empty($_POST["confirm-password"]) && !empty($_POST["question1"]) && 
                    !empty($_POST["question2"]) && !empty($_POST["question3"]);
    
        // Verificar que no esten vacios
        if($no_empty){
            $nombre = htmlspecialchars($_POST["nombre"]);
            $apellido = htmlspecialchars($_POST["apellido"]);
            $cedula = filter_var(htmlspecialchars($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT));
            $municipio = htmlspecialchars($_POST["municipio"]);
            $direccion = htmlspecialchars($_POST["dirección"]);
            $contraseña = htmlspecialchars($_POST["password"]);
            $confirmar_contraseña = htmlspecialchars($_POST["confirm-password"]);
            $question1 = htmlspecialchars($_POST["question1"]);
            $question2 = htmlspecialchars($_POST["question2"]);
            $question3 = htmlspecialchars($_POST["question3"]);
        }else{
            $_SESSION['error'] = "Todos Los campos son obligatorios";
            header('location: register.php');
            exit;
        }
    
        // Verificar si un usuario ya esta registrado con la cedula
        $encontrarUsuario = $pdo->prepare("SELECT * FROM usuarios WHERE cedula = :cedula");
        $encontrarUsuario->bindParam(':cedula', $cedula);
        $encontrarUsuario->execute();
    
        if($resultado = $encontrarUsuario->fetchAll(PDO::FETCH_ASSOC)){
            $_SESSION['error'] = "Ya existe un usuario registrado con esa cedula";
            header('location: register.php');
            exit;
        }
    
        // Longitud de cedula y password
        if((strlen($cedula) < 7 || strlen($cedula) > 8)  && (strlen($contraseña) < 8 || strlen($contraseña) > 15)){
            $_SESSION['error'] = "La cedula debe tener 7 digitos o 8 ";
            $_SESSION['error'] .= "<br>La contraseña debe tener 8 a 15 caracteres";
            header('location: register.php');
            exit;
        }else if(strlen($cedula) < 7 || strlen($cedula) > 8){
            $_SESSION['error'] = "La cedula debe tener 7 digitos o 8";
            header('location: register.php');
            exit;
        }else if((strlen($contraseña) < 8 || strlen($contraseña) > 15)){
            $_SESSION['error'] = "La contraseña debe tener 8 a 15 caracteres";
            header('location: register.php');
            exit;
        }

        //expresion regular para validar solo letras
        $letras = "/^[a-zA-Z ]*$/";

        //expresion regular para validar solo numeros
        $numeros = "/^[0-9]*$/";
        
        //expresion regular para colocar una contraseña con al menos una letra mayuscula, una minuscula y un numero y un caracter especial
        $contraseñaRegular = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}$/";

        if(!preg_match($letras, $nombre) || !preg_match($letras, $apellido)){
            $_SESSION['error'] = "El nombre y apellido solo pueden contener letras";
            header('location: register.php');
            exit;
        }

        if(!preg_match($numeros, $cedula)){
            $_SESSION['error'] = "La cedula solo puede contener numeros";
            header('location: register.php');
            exit;
        }

        if(!preg_match($letras, $municipio)){
            $_SESSION['error'] = "El municipio solo puede contener letras";
            header('location: register.php');
            exit;
        }

        if(!preg_match($contraseñaRegular, $contraseña)){
            $_SESSION['error'] = "La contraseña debe tener al menos una letra mayuscula, una minuscula, un numero y un caracter especial";
            header('location: register.php');
            exit;
        }

        if(!preg_match($letras, $question1) || !preg_match($letras, $question2) || !preg_match($letras, $question3)){
            $_SESSION['error'] = "Las respuestas solo pueden contener letras";
            header('location: register.php');
            exit;
        }
    
        //Comprobar si las contraseñas son distintas
        if($contraseña != $confirmar_contraseña){
            $_SESSION['error'] = "las contraseñas no coinciden";
            header('location: register.php');
            exit;
        }

        //Encriptar contraseña
        $password_hashed = password_hash($contraseña, PASSWORD_BCRYPT);

        // Crear el Usuario en la BD
        try{
            $crearUsuario = $pdo->prepare("INSERT INTO usuarios(rol, nombre, apellido, cedula, contrasenia, municipio, direccion) VALUES (2,:nombre, :apellido, :cedula, :contrasenia, :municipio, :direccion);");
            $crearUsuario->bindParam(':nombre', $nombre);
            $crearUsuario->bindParam(':apellido', $apellido);
            $crearUsuario->bindParam(':cedula', $cedula);
            $crearUsuario->bindParam(':contrasenia', $password_hashed);
            $crearUsuario->bindParam(':municipio', $municipio);
            $crearUsuario->bindParam(':direccion', $direccion);
            
            $crearUsuario->execute();

            $insertarPreguntas = $pdo->prepare("INSERT INTO preguntas(id_usuario, respuesta1, respuesta2, respuesta3) VALUES (:id_usuario, :respuesta1, :respuesta2, :respuesta3);");
            $insertarPreguntas->bindParam(':id_usuario', $cedula);
            $insertarPreguntas->bindParam(':respuesta1', $question1);
            $insertarPreguntas->bindParam(':respuesta2', $question2);
            $insertarPreguntas->bindParam(':respuesta3', $question3);    
            $insertarPreguntas->execute();

            header('location: register.php');    
            $_SESSION['success'] = "Usuario registrado correctamente";
        }catch(PDOException $e){
            $_SESSION['error'] = "Usuario no registrado correctamente";
            header('location: register.php');
        }
    }
?>