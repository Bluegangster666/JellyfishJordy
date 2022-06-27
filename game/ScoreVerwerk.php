<?php

//start session
session_start();

//connect to database
require "../DatabaseConnect.php";


if($_SERVER['HTTP_REFERER'] = 'https://86900.ict-lab.nl/pjc/JellyfishJordy_2.0/game/index.html') {
    if(!empty($_GET['score'])){
        $id = RandomID();
        $User = $_SESSION["UserID"];
        $Score = $_GET['score'];

        //check score
        if (!filter_var($Score, FILTER_VALIDATE_INT)) {
            header("Location: index.html");
        } 
        else {
            //add score to database
            $Add_user_query = "INSERT INTO `Leaderboard`(`ID`, `UserID`, `score`) VALUES (:ID,:User,:Score)";
            if ($statement = $database->prepare($Add_user_query)) {
                $statement->bindParam(":ID", $id, PDO::PARAM_STR);
                $statement->bindParam(":User", $User, PDO::PARAM_STR);
                $statement->bindParam(":Score", $Score, PDO::PARAM_STR);
                $statement->execute();
                header("Location: ../Leaderboard.php?ID=$id");
            }
        }
    }
    else {
        header("Location: ../Leaderboard.php");
    }
}
else {
    header("Location: https://86900.ict-lab.nl/pjc/JellyfishJordy_2.0/game/index.html");
}

?>