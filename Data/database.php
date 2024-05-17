<?php
define("SITEURL", "http://localhost:3306");

$host = "localhost"; 
$db_username = "root";
$db_password = "root";
$database = "Evelicious_munch";

//$conn = new mysqli($host, $db_username, $db_password, $database);
$conn = new mysqli('localhost', 'root', 'root', 'Evelicious_munc...');


if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

if (!$conn->set_charset("utf8mb4")) {
    printf("Erreur lors du chargement du jeu de caractères utf8mb4 : %s\n", $conn->error);
    exit();
}

try {
    $mysqli = new mysqli('localhost', 'root', 'root', 'Evelicious_munc');
} catch (mysqli_sql_exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}


