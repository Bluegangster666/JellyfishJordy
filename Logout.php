<?php
session_start();

if ($_SESSION["UserID"] != NULL) {
    session_destroy();
}   
header("Location: Login.php");


?>