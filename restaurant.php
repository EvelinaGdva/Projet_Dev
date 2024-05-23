<?php include('menu-front/menu.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <link rel="stylesheet" href="CSS/restaurant.css">
</head>
<body>

<div class="container">
    <h1>Restaurant</h1>
    <?php
    include 'Data/database.php';

    if (isset($_GET['id'])) {
        $restaurant_id = $_GET['id'];

        $sql_restaurant_info = "SELECT * FROM restaurant WHERE id = $restaurant_id";
        $result_restaurant_info = $conn->query($sql_restaurant_info);

        if ($result_restaurant_info->num_rows > 0) {
            $row_restaurant_info = $result_restaurant_info->fetch_assoc();
            echo "<h2>Nom du restaurant: " . $row_restaurant_info["restaurant_name"] . "</h2>";
            echo "<p>Description: " . $row_restaurant_info["description"] . "</p>";
            echo "<p>Email: " . $row_restaurant_info["email"] . "</p>";
            echo "<p>Adresse: " . $row_restaurant_info["address"] . "</p>";
            echo "<img src='images/logos/" . $row_restaurant_info["logo"] . "' alt='" . $row_restaurant_info["restaurant_name"] . "'>";
        } else {
            echo "Informations sur le restaurant non trouvées.";
        }
    } else {
        echo "ID du restaurant non spécifié.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
