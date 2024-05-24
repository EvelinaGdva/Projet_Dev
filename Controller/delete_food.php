<?php

require_once "../Data/database.php";

// Vérifier si l'ID du plat est fourni
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];



    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Supprimer le plat de la base de données
    $sql = "DELETE FROM food WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $food_id);

    if ($stmt->execute()) {
        // Redirection vers la page de gestion après la suppression
        header("Location: update_food.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du plat: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: update_food.php");
}
?>
