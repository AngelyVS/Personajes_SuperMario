<?php

//Crear  conexión con la base de datos 
$host = 'localhost';
$dbName = 'super_mario'; //nombre de la base de datos
$userName = 'root'; //usuario
$password = ''; // contraseña, en este caso no está definida

$conexion = new mysqli($host,$userName,$password,$dbName);

if($conexion->connect_errno){
    echo "Conexión con la Base de datso fallida";
    exit();
}

?>