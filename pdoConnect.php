<?php 

$dsn = "mysql:host=database;dbname=finelia"; 
$user = "root"; 
$password = "password"; 

try {
    $pdo = new PDO($dsn, $user, $password); 
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}