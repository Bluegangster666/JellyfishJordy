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
        if (isset($_SESSION['token']) && $_SESSION['token'] = $_POST["csrf_token"]) {
            //check if input is empty
            if (!empty($_POST['Naam']) && !empty($_POST['Email']) && !empty($_POST['Wachtwoord'])) {
                //create variables for check
                $email = $_POST['Email'];
                $naam = $_POST['Naam'];
                $password = $_POST['Wachtwoord'];
                $patroon_wachtwoord = "/(?=.*[^\w])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}/";

                //password check
                if (!preg_match($patroon_wachtwoord, $password)) {
                    $melding = "<p class='c-red'>Wachtwoord moet minimaal 8 karacters hebben en moet 1 hoofdletter, 1 nummer en 1 speciale teken</p>";
                } 
                else {
                    if ($_POST['Wachtwoord'] != $_POST['Wachtwoord_check']) {
                        $melding = "<p class='c-red'>Wachtwoord is niet hetzelfde</p>";
                    } 
                    else {
                        //check inputs
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $melding = "<p class='c-red'>Verkeerde Email</p>";
                        } 
                        else {
                            //encrypt wachtwoord
                            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

                            //add user to database
                            $Add_user_query = "INSERT INTO `User` (`Email`, `Username`, `Password`) VALUES (:Email, :Naam, :Wachtwoord)";
                            if ($statement = $database->prepare($Add_user_query)) {
                                $statement->bindParam(":Naam", $naam, PDO::PARAM_STR);
                                $statement->bindParam(":Email", $email, PDO::PARAM_STR);
                                $statement->bindParam(":Wachtwoord", $encrypt_pass, PDO::PARAM_STR);

                                if ($statement->execute()) {
                                    header('location: Login.php');
                                } 
                                else {
                                    $melding = "<p class='c-red'>Email wordt al gebruikt door andere gebruiker</p>";
                                }
                            }
                        }
                    }
                }
            } 
            else {
                $melding = "<p class='c-red'>Niet alles is ingevuld</p>";
            }
        } 
        else {
            header('location: https://86900.ict-lab.nl/JellyfishJordy/Register.php');
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
    <title>Jellyfish Jordy | Register Turning into a fish</title>

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
            <form method="POST" action="Register.php" autocomplete="off">

                <?php echo "<input type='hidden' name='csrf_token' value='" . $token . "'>" ?>

                <h1>Registreer</h1>
                <div class="register_username">
                    <label for="Gebruikersnaam">Gebruikersnaam:</label>
                    <input type="text" name="Naam" value="<?php echo $_POST['Naam']; ?>" required>
                </div>

                <div class="register_email">
                    <label for="Email">Email:</label>
                    <input type="email" name="Email" value="<?php echo $_POST['Email']; ?>" required>
                </div>

                <div class="register_password">
                    <label for="Wachtwoord">Wachtwoord:</label>
                    <input type="password" name="Wachtwoord" pattern="(?=.*[^\w])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Wachtwoord moet minimaal 8 karacters hebben en moet 1 hoofdletter, 1 nummer en 1 speciale teken" required>
                </div>

                <div class="register_password">
                    <label for="Wachtwoord check">Wachtwoord herhalen:</label>
                    <input type="password" name="Wachtwoord_check" required>
                </div>

                <input class="btn" type="submit" name="submit" value="Registreer" require>
                <br><br>
                <p>Heeft u wel een account? <a href="Login.php" class="register">Log in</a></p>
                <?php echo $melding; ?>
            </form>

        </div>
    </div>
</body>

</html>