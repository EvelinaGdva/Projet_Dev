<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du restaurant</title>
    <link rel="stylesheet" href="CSS/gestion_restaurateur.css">
    <script>
        function confirmDeletion(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce plat ?")) {
                window.location.href = 'Controller/delete_food.php?id=' + id;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Gestion du restaurant</h1>
    <?php
    // Connexion à la base de données
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

    // Récupérer le nom du restaurant
    $sql_restaurant_name = "SELECT restaurant_name FROM restaurant";
    $result_restaurant_name = $conn->query($sql_restaurant_name);
    if ($result_restaurant_name->num_rows > 0) {
        $row_restaurant_name = $result_restaurant_name->fetch_assoc();
        echo "<h2>Nom du restaurant: " . $row_restaurant_name["restaurant_name"] . "</h2>";
    } else {
        echo "Nom du restaurant non trouvé.";
    }

    // Récupérer les plats ajoutés par le restaurant
    $sql_plats = "SELECT * FROM food";
    $result_plats = $conn->query($sql_plats);

    // Vérifier s'il y a des plats
    if ($result_plats->num_rows > 0) {
        // Afficher les plats
        echo "<h2>Plats ajoutés</h2>";
        while($row_plat = $result_plats->fetch_assoc()) {
            echo "<div class='plat'>";
            echo "<h3>" . $row_plat["food_name"] . "</h3>";
            echo "<img src='images/food/" . $row_plat["image"] . "' alt='" . $row_plat["food_name"] . "'>";
            echo "<p>Description: " . $row_plat["food_description"] . "</p>";
            echo "<p>Prix: " . $row_plat["food_price"] . "</p>";
            echo "<div class='buttons'>";
            echo "<a href='Controller/update_food.php?id=" . $row_plat["id"] . "' class='btn-edit'>Modifier</a>";
            echo "<a href='#' onclick='confirmDeletion(" . $row_plat["id"] . ")' class='btn-delete'>Supprimer</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Aucun plat ajouté pour le moment.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
    <a href="index_restaurateur.php" class="btn-add">Ajouter d'autres plats</a>
</div>

</body>
</html>
