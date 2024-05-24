<?php
// Connexion à la base de données
require_once "Data/database.php";

// Récupérer les aliments depuis la base de données
$sql = "SELECT id, image, food_name, food_description, food_price FROM food"; 
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Aliments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste des Aliments</h1>
    <table>
        <tr>
             <th>Image</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Afficher les données de chaque aliment
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='" . $row["image"] . "' alt='Image de " . $row["food_name"] . "' width='100'></td>";
                echo "<td>" . $row["food_name"] . "</td>";
                echo "<td>" . $row["food_description"] . "</td>";
                echo "<td>" . $row["food_price"] . " €</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun aliment trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
