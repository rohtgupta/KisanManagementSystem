<?php

$server = "localhost";
$port = 3306;
$username = "roht";
$password = "lab6";
$mydb = "cropkart";

try{
    $conn = new PDO("mysql:host=$server; port= $port, dbname=$mydb", $username, $password);

    $conn->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $message = "Connected to $mydb";
    
}catch(PDOException $e){
    echo $e->getMessage();
    die();
}

?>

