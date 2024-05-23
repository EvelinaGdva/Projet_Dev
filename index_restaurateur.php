<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="CSS/index_restaurateur.css">
</head>
<body>

<div class="container">
    <h1>Gestion des plats</h1>
    <form action="actions.php" method="post" enctype="multipart/form-data">
        <label for="food_name">Nom du plat:</label><br>
        <input type="text" id="food_name" name="food_name" required><br><br>
        
        <label for="food_image">Image:</label><br>
        <input type="file" id="food_image" name="food_image" accept="image/*" required><br><br>
        
        <label for="food_description">Description:</label><br>
        <textarea id="food_description" name="food_description" required></textarea><br><br>
        
        <label for="food_price">Prix:</label><br>
        <input type="number" id="food_price" name="food_price" min="0" step="0.01" required><br><br>
        
        <input type="submit" value="Ajouter">
    </form>
</div>

<div class="plats">
    <h2>Plats disponibles</h2>

    <?php
    // Connexion à la base de données (à remplacer par vos propres informations de connexion)
    $host = "localhost"; 
    $db_username = "root";
    $db_password = "root";
    $database = "evelicious_munch";
    $port = 8888;

    $conn = new mysqli($host, $db_username, $db_password, $database, $port);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer les plats depuis la base de données
    $sql = "SELECT * FROM plats";
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Afficher les plats
        while($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . $row["food_name"] . "</h3>";
            echo "<img src='" . $row["image"] . "' alt='" . $row["food_name"] . "'>";
            echo "<p>" . $row["food_description"] . "</p>";
            echo "<p>Prix: " . $row["food_price"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "Aucun plat trouvé.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</div>

</body>
</html>
