<?php
include 'database.php';

// Fonction pour récupérer les détails d'un utilisateur par son ID
function get_user_details($user_id) {
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $result = execute_query($sql);
    return $result->fetch_assoc();
}

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$sql = "UPDATE user SET user ='nouveau_nom_utilisateur' WHERE user_id=1";

if ($conn->query($sql) === TRUE) {
    echo "Détails de l'utilisateur mis à jour avec succès";
} else {
    echo "Erreur lors de la mise à jour des détails de l'utilisateur : " . $conn->error;
}
?>
