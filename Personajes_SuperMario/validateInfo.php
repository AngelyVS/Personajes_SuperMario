<?php
session_start();
require_once 'conexion.php';


$errores = [];

if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST != ''){
//Recogen los datos
    $userName = $_POST['user'] ?? null;
    $password = $_POST['password'] ?? null;

//Comprueba que lo datos no sean vacío y cumpla con el formato
    if(empty($userName)){
        $errores[] = "Introduce un nombre primero";
    }

    if(is_numeric($userName)){
        $errores[] = "El Campo nombre debe contener letras";
    }

    if(empty($password)){
        $errores[] = "Introduce una contraseña primero";
    }
    if($password == ''){
        $errores[] = "El campo contraseña no puede ser vacío";
    }
    if(strlen($password) < 5  || strlen($password) > 10){
        $errores[]= "El campo contraseña debe tener minímo 5 caracteres, mayor a 10";
    }
 
    
//si existe errores asigna el estado para que se puedan mostrar el mensaje
//en el Index
    if(!empty($errores)){
        foreach($errores as $error){
            echo json_encode(["status" => "error", "message" => "$error"]);
        }
    }else{
        //si no hay errores se agregan los datos a la sesión
       $_SESSION['name'] = $userName;
       $_SESSION['password'] = $password;

        
        $exist = 0;//Variable bandera
        $resultSearch=[];

        //Consultar si existe el Usuario
        $search = mysqli_query($conexion,"SELECT * FROM usuarios WHERE nombre = '$userName'  ");
        while($results = mysqli_fetch_array($search)){
            $resultSearch = $results;
             $exist++;
        }

        //si Lo datos no existen se insertan
        if($exist == 0){
            $insert = mysqli_query($conexion,"INSERT INTO usuarios (nombre,contraseña) VALUES ('$userName','$password')");
            echo json_encode(["message" => "Usuario registrado con éxito."]);
        }else{
            //si los datos existen no se inserta, sino que se comprueba la contraseña
            //y se asigna un estado para redirijir en caso esta sea correta
           if($resultSearch['contraseña'] === $password){
            $_SESSION['id']= $resultSearch['id'];
                echo json_encode(["status" => "Bienvenido", "redirect" => "list.php"]);
            }else{
                echo json_encode(["status" => "error", "message" => "Usuario registrado: Credenciales incorrectas."]);
            }
             exit;   
        }
            
    }
}


?>