<?php
ob_start();
session_start();

$timezone = date_default_timezone_set("Europe/Paris");

try{
    $conn = new PDO('mysql:host=localhost;dbname=tweet_academy', 'root', '');
    // echo "CONNECTED" . "<br>";
} catch(PDOException $e) {
    echo "ERROR" . $e->getMessage();
}