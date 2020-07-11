<?php 

$dsn = "mysql:host=localhost;dbname=finelia"; 
$user = "root"; 
$password = ""; 

try {
    $pdo = new PDO($dsn, $user, $password); 
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}