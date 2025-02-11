<?php
session_start();
require_once 'conexion.php';
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Recogida de datos
    $quantity = $_POST['quantity'];
    $idPer = $_POST['idPer'];
    $idUs = $_SESSION['id'];
    $response = ["message" => "Error desconocido","media" => 0];   


    if(!empty($quantity) && !empty($idPer) && !empty($idUs) ){
  
    //Se obtinen los votos con el usuario y el presonaje coincida
        $searchVote = mysqli_query($conexion, "SELECT * FROM votos WHERE idPer = '$idPer' AND idUs = '$idUs'");

        //Si el usuario no ha valorado el personaje se inserta el voto
        if(mysqli_num_rows($searchVote) == 0){
            $insertVote = mysqli_query($conexion, "INSERT INTO votos (cantidad, idPer,idUs) VALUES ('$quantity','$idPer','$idUs')");
           
            if ($insertVote) {
                //Si sea insertado corrextamente se almacena un mensaje
                $response["message"] = "Valoración almacenada";
            } else {
                $response["message"] = "Error al insertar la valoración";
            }
        }else{
            //Si el usaurio ya ha realizado una valoración se le inidica
            $response["message"] = "Ya ha valorado este personaje";
        }
        //Se obtienen los votos de un mismo persoaje y se genera el promedio
        $avgQuery = mysqli_query($conexion, "SELECT AVG(cantidad) as promedio FROM votos WHERE idPer = '$idPer'");
        
        //Si la consulta se ha realizado con exito se almacena el promedio y se envía al página list.php
        if ($avgQuery) {
            $avgResult = mysqli_fetch_assoc($avgQuery);
            $media = round($avgResult['promedio'], 2); 
            $response["media"] = $media;

        } else {
            $response["message"] = "Error al calcular la media";
        }
    }else{
        $response["message"] = "Datos no recibidos";
    }
    echo json_encode($response);
    exit();
} 
?>