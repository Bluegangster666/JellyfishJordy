<?php

//start session
session_start();

//connect to database
require "DatabaseConnect.php";

if ($_SESSION["UserID"] == NULL) {
    header("Location: Login.php");
}
else {
    if (!empty($_GET["ID"])) {
        //Get ID from URL
        $ID = $_GET["ID"];
    }
    
    // retreve leaderboard from database
    $statement = $database->prepare("SELECT * FROM `Leaderboard` ORDER BY `score` DESC LIMIT 10");
    $statement->execute();
    $users = $statement->fetchAll();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- SEO -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A game with the greatest jellyfish called Jordy">
    <title>Jellyfish Jordy | Leaderboard being the best fish</title>

    <!-- icon -->
    <link rel="icon" type="image/png" href="Media/SEO/favicon.png" />
    <link rel="shortcut icon" href="Media/SEO/favicon.png" type="image/png">
    <link rel="shortcut icon" href="" type="Media/SEO/favicon.ico" id="favicon" />
    <link rel="apple-touch-icon" type="image/png" href="Media/SEO/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="CSS/Leaderboard/Leaderboard.css">
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

        <div class="leaderboard">
            <h1>Leaderboard</h1>

            <table class="tabelletje">
                <thead>
                    <th>Gebruikersnaam</th>
                    <th>Punten</th>
                </thead>
                
                    <?php
                    
                        foreach ($users as $row) {
                            if ($row['ID'] == $ID) { ?>
                            <tr class="ownrow">
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['score']; ?></td>
                            </tr>
                            <?php
                            }
                            else { ?>
                            <tr>
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['score']; ?></td>
                            </tr>
                            <?php
                            }
                        }
                    
                    ?>
                    
            </table>
        </div>

    </div>
</body>

</html>