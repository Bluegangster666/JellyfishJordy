<?php

//start session
session_start();

if ($_SESSION["UserID"] == NULL) {
    header("Location: Login.php");
} 

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <!-- SEO -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A game with the greatest jellyfish called Jordy">
    <title>Jellyfish Jordy | Login Turning into a fish</title>

    <!-- icon -->
    <link rel="icon" type="image/png" href="Media/SEO/favicon.png" />
    <link rel="shortcut icon" href="Media/SEO/favicon.png" type="image/png">
    <link rel="shortcut icon" href="" type="Media/SEO/favicon.ico" id="favicon" />
    <link rel="apple-touch-icon" type="image/png" href="Media/SEO/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/Home/Home.css">
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body class="animate__animated animate__fadeIn">
    <div class="container">

        <div class="header">
            <h1 id="colorSwitch"> <a href="Home.php"> Home</a></h1>
            <a href="Leaderboard.php"> <button class="lb"> <i class='fa fa-trophy'></i> LEADERBOARD</button> </a>
            <a target="_blank" href="game/index.html"> <button class="play">▶ PLAY</button> </a>
            <a href="Logout.php"> <button class="logout">LOG OUT</button> </a>
        </div>

        <div class="void0">
        </div>

        <div class="void1">
        </div>

        <div class="aboutUs">
            
            <div class="title">
                <h2>Over ons</h2>
            </div>

            <div class="dev1">
                <img class="pfp" src="Media/Admin/pfp1.png">
                <h3>Josh Agripo</h3>
                <p>Hey mijn naam is Josh Agripo. Momenteel zit ik op het GLR. Voor dit project heb ik het spel gemaakt. Hievoor maakte ik een engine in js</p>
            </div>
            
            <div class="dev2">
                <img class="pfp" src="Media/Admin/pfp2.png">
                <h3>Christopher Garcia</h3>
                <p>Hey mijn naam is Christopher Garcia. Ik doe de opleiding Software Developer bij het Grafisch Lyceum. Voor dit project heb ik gewerkt aan de back- en front-end van deze website. Probeer maar een foute input in mijn database te zetten.</p>
            </div>

            <div class="dev3">
                <img class="pfp" src="Media/Admin/pfp3.png">
                <h3>Alexandros Papadakis</h3>
                <p>Hallo! Mijn naam is Alexandros Papadakis. Ik studeer Software Developer bij het Grafisch Lyceum ter Rotterdam. Voor dit project heb ik gewerkt aan de front-end van deze website.</p>
            </div>
        </div>

        <div class="AboutGame">
            <h2>Over het spel</h2>
            <p>*Algemene info*</p>
            <h3>Over de ontwikkeling</h3>
            <p>*wat hierboven staat lmao*</p>
            <h3>Over onze ervaring</h3>
            <p>*wat hierboven staat lmao*</p>
            <h3>Over onze mening</h3>
            <p>*wat hierboven staat lmao*</p>
        </div>

    </div>   
    
    <!-- js -->
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="JS/Home.js"></script> -->
</body>

</html>