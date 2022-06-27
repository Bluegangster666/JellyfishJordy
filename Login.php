<?php

//start session
session_start();

//connect to database
require "DatabaseConnect.php";

if ($_SESSION["UserID"] != NULL) {
    header("Location: Home.php");
} 
else {
    //check if submitted
    if (isset($_POST["submit"])) {
        //check for token
        if (isset($_SESSION["token"]) && $_SESSION["token"] = $_POST["csrf_token"]) {
            //check if input is empty
            if (!empty($_POST['Username']) && !empty($_POST['Wachtwoord'])) {
                
                $User = $_POST['Username'];
                $password = $_POST['Wachtwoord'];

                //check user in database
                $check_user_query = "SELECT * FROM `User` WHERE `Username` = :Username;";
                if ($statement = $database->prepare($check_user_query)) {
                    $statement->bindParam(":Username", $User, PDO::PARAM_STR);
                    if ($statement->execute()) {
                        if ($row = $statement->fetchAll()) {
                            for ($i = 0; $i < count($row); $i++) {
                                if (password_verify($password, $row[$i]["Password"])) {
                                    $_SESSION["UserID"] = $row[$i]["Email"];
                                    header('location: Home.php');
                                } 
                                else {
                                    $melding = "<p class='c-red'>Gebruikersnaam of wachtwoord is incorrect</p>";
                                }
                            }
                        } 
                        else {
                            $melding = "<p class='c-red'>Gebruikersnaam of wachtwoord is incorrect</p>";
                        }
                    }
                }
            } 
            else {
                $melding = "<p class='c-red'>Niet alles is ingevuld</p>";
            }
        } 
        else {
            header('location: https://86900.ict-lab.nl/JellyfishJordy/Login.php');
        }
    }
}

$token = uniqid(); 
$_SESSION['token'] = $token;

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
    <link rel="stylesheet" href="CSS/Login/Login.css">

</head>

<body>
    <div class="container">
        <div class="login">
            <form method="post" action="Login.php" autocomplete="off">
                <input type="hidden" name="csrf_token" <?php echo "value='$token'" ?>>
                <h1>Login:</h1>
                <label for="username">Gebruikersnaam:</label>
                <input type="text" name="Username" id="username" value="<?php echo $_POST['Username']; ?>" required>
                <br>
                <label for="password">Wachtwoord:</label>
                <input type="password" name="Wachtwoord" id="password" required>
                <br>
                <button class="btn" name="submit" id="submit">Inloggen</button>
                <br><br>
                <p>Heeft u geen account? <a href="Register.php" class="register">Registreren</a></p>
                <?php echo $melding; ?>
            </form>
        </div>
    </div>
</body>

</html>