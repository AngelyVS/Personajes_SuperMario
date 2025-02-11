<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="ajax.js"></script>
    <title>Formulario de Registro</title>
    <!--Funete 1-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!--Fuente 2-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <!--Fuente 3-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
        
</head>
<body>
    <form id="register" >

        <h2>Formulario de Registro</h2>

        <label for="">Usuario</label>
        <input type="text" name="user" id="fieldName" class="campo">

        <label for="">Contraseña</label>
        <input type="password" name="password" id="passwordField" class="campo">

        <input type="submit" value="Registrar" id="boton" >

    </form>

    <div id="showMessage"></div>

    <script>
        //Se selecciona por Id el formulario del cúal se obtendran  los datos
        //y se indica la función a ejecutar al presionar el botón
        document.getElementById("register").addEventListener("submit",function(e){
            e.preventDefault();

            //almacenan los datos en una variable 
            let dataUser = new FormData(this);

            //Indica la página que recibirá los datos y el método a usar
            //posteriormente se indica el formati en el que se va a recibir la respuesta (json)
            fetch("validateInfo.php", {method: "POST", body: dataUser})
            .then(res => res.json())
            .then(result =>{
                //se espera un valor del estado asignado en la  página validateInfo.php 
                //para redireciionar o mostrar un mensaje de error
                if(result.status === "Bienvenido"){
                    window.location.href = result.redirect;
                }else{
                    document.getElementById("showMessage").innerHTML = result.message;
                }
             })
            .catch(error => console.error("Error",error));

        });
    </script>
</body>
</html>