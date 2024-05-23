<?php
// Vérifier si l'administrateur est connecté
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
require_once "Data/database.php"; // Assurez-vous d'inclure le fichier de connexion à la base de données

// Récupérer les aliments depuis la base de données
$sql = "SELECT * FROM food";
$result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Administrateur</title>
</head>
<body>
    <h1>Liste des Aliments</h1>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th> <!-- Ajouter une colonne pour les actions -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Afficher les données de chaque aliment
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["food_name"] . "</td><td>" . $row["food_description"] . "</td>";
                echo "<td>";
                echo "<a href='Controller/update_food_admin.php?id=" . $row['id'] . "'>Modifier</a> | ";
                echo "<a href='Controller/delete_food_admin.php?id=" . $row['id'] . "'>Supprimer</a>";
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Aucun aliment trouvé</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="logout.php">Déconnexion</a> <!-- Ajoutez un lien de déconnexion -->
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
