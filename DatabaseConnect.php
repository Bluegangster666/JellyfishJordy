<?php

$Hostname = "127.0.0.1";
$username = "db86900";
$password = "Zelda313!";
$dbName = "86900_aqua_game";

try {
    $database = new PDO("mysql:host={$Hostname};dbname={$dbName}", $username, $password);
} catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}



function RandomID()
{
    $data = openssl_random_pseudo_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

