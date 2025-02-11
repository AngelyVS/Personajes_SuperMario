<?php
session_start();
require_once 'conexion.php';

$characters = [];
//Se obtienen todos los personajes
$searchs = mysqli_query($conexion, "SELECT * FROM personajes");
while($results = mysqli_fetch_array($searchs)){
    $characters[] = $results;
   
}

$votes = []; 
//Se obtienen todos los Votos
$searchRating = mysqli_query($conexion, "SELECT * FROM votos");
while($results =mysqli_fetch_array($searchRating)){
    $votes[] = $results;
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
    <link rel="stylesheet" href="style2.css">
    <title>Valoraciones</title>
</head>
<body>
    <nav>
        <img src="imagenes/logo.png" alt="" id="logo">
        <ul>
            <li>
               <img src="imagenes/logoUser.png" alt="" id="logoUser">
                <?php echo $_SESSION['name']?>
            </li>
            <li>
                <img src="imagenes/logoSalir.png" alt="" id="logoSalir">
                <a href="index.php">Salir</a>
            </li>
                
        </ul>
    </nav>

    <h1>Valora tus personajes favoritos</h1>
    <div id="galery">
    <?php
    
    /*Se recorren todos los personajes y dentro del mismo 
    bucle, se recorren los votos y se almacena en una variable,
    posteriormente se busca si existe un voto de un personaje 
    por el mismo usuario.

    Si no hay un voto, se genera automaticamente una carta que contiene
    al personaje y un formulario individual para realizar la votación
    
     */
        foreach($characters as $character){
            $numberVotes = 'sin valorar';
            $userHasVoted = false;
            foreach($votes as $vote ){
                
                if($character['id'] == $vote['idPer']){
                    $numberVotes= $vote['cantidad'];
                    if ($vote['idUs'] == $_SESSION['id']) {
                        $userHasVoted = true;
                    }
                }
             }
         ?>   
            <div class='card'>
            <div class='image' >
                <img src="<?php echo $character['imagen1']?>" alt="" class="personaje1">
                <img src="<?php echo $character['imagen2']?>" alt="" class="personaje2">
            </div>
            <div class="stars-container">
               <div class="container">
                <img src="imagenes/mediaEstrella.png" alt="" class="media">
                <img src="imagenes/estrella1.png" alt="" id="start1" class="stars">
                <img src="imagenes/estrella2.png" alt="" id="start2" class="stars2">
               </div>

               <div class="container">
                 <img src="imagenes/mediaEstrella.png" alt="" class="media">
                 <img src="imagenes/estrella1.png"  alt="" id="star3" class="stars">
                 <img src="imagenes/estrella2.png" alt="" id="star4" class="stars2">
                </div>

                <div class="container">
                <img src="imagenes/mediaEstrella.png" alt="" class="media">
                <img src="imagenes/estrella1.png"  alt="" id="star5" class="stars">
                <img src="imagenes/estrella2.png"  alt="" id="star6" class="stars2">
                </div>

               <div class="container">
                <img src="imagenes/mediaEstrella.png" alt="" class="media">
               <img src="imagenes/estrella1.png"  alt="" id="star7" class="stars">
               <img src="imagenes/estrella2.png"  alt="" id="star8" class="stars2">
               </div>

               <div class="container">
               <img src="imagenes/mediaEstrella.png" alt="" class="media">
               <img src="imagenes/estrella1.png"  alt="" id="star9" class="stars">
               <img src="imagenes/estrella2.png"  alt="" id="star10" class="stars2">
               </div>
            </div>
    <?php   
            //echo $character['id'];
            echo "<p id='name'>". $character['nombre']."</p>";
            
            ?>  
            <form class="vote-form" >
            <select name="quantity" id="">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="hidden" name="idPer" value="<?= htmlspecialchars($character['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" value="valorar">
            </form>

                <div id="showMessage"> 
                    <?= $userHasVoted ? "<p>Ya has votado este personaje.</p>" : "" ?>
                </div>
            </div>
            
        <?php     
            }
        
        ?>
</div>
    <script>

    function highlightStars(rating, starsContainer) {
        const fullStars = starsContainer.querySelectorAll(".stars2");       
        const halfStars = starsContainer.querySelectorAll(".media");  
        const emptyStars = starsContainer.querySelectorAll(".stars");   

        // Convierte la media a un número para trabajar con decimales
        const fullStarsCount = Math.floor(rating);  
        const hasHalfStar = rating % 1 >= 0.5;  // Verifica si hay media estrella

        // Limpia todas las estrellas
        fullStars.forEach(star => star.style.display = "none");
        halfStars.forEach(star => star.style.display = "none");
        emptyStars.forEach(star => star.style.display = "block");

        // Muestra las estrellas completas según la media
        for (let i = 0; i < fullStarsCount; i++) {
            fullStars[i].style.display = "block";
            emptyStars[i].style.display = "none";
        }

        // Si hay media estrella, hace visible la estrella
        if (hasHalfStar && fullStarsCount < 5) {
            halfStars[fullStarsCount].style.display = "block";  
            emptyStars[fullStarsCount].style.display = "none"; 
        }
    }

    // Llama a la función cuando se recive la media
    document.querySelectorAll(".vote-form").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            let dataUser = new FormData(this);
            let showMessage = this.closest('.card').querySelector("#showMessage");
            let starsContainer = this.closest('.card').querySelector(".stars-container");
            //Indica a donde se inviarán los datos y el método a usar
            fetch("insertVote.php", { method: "POST", body: dataUser })
                .then(res => res.json())
                .then(result => {
                    showMessage.innerHTML = `<p>${result.message}</p><p>Media: ${result.media} / 5</p>`;
                    
                    // Llama a la función para actualizar las estrellas
                    highlightStars(result.media, starsContainer);

                    if (result.message.includes("Valoración almacenada")) {
                        this.style.display = "none";
                    }
                })
                .catch(error => console.error("Error", error));
        });
    });

    </script> 
    
<footer>
    <p>© SUPER MARIO BROS</p>
    <div id="icon-container">
    <img src="imagenes/icon1.png" alt="" class="icons">
    <img src="imagenes/icon2.png" alt="" class="icons">
    <img src="imagenes/icon3.png" alt="" class="icons">
    </div>
    
</footer>
</body>
</html>
