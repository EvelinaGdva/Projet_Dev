<?php
session_start(); // Démarrez la session si ce n'est pas déjà fait


// Vérifiez si le formulaire de mise à jour a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $restaurant_name = $_POST["restaurant_name"];
    $restaurant_address = $_POST["restaurant_address"];
    $restaurant_phone = $_POST["restaurant_phone"];

    // Connexion à la base de données
    $host = "localhost";
    $db_username = "root";
    $db_password = "root";
    $database = "evelicious_munch";
    $port = 8888;

    $conn = new mysqli($host, $db_username, $db_password, $database, $port);

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer l'identifiant du restaurant à partir de la session
    $restaurant_id = $_SESSION['restaurant_id'];

    // Préparer et exécuter la requête de mise à jour
    $sql = "UPDATE restaurant SET restaurant_name = '$restaurant_name', restaurant_address = '$restaurant_address', restaurant_phone = '$restaurant_phone' WHERE id = $restaurant_id";

    if ($conn->query($sql) === TRUE) {
        // Rediriger vers la page compte_restaurateur.php après la mise à jour
        header("Location: compte_restaurateur.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du restaurant: " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
