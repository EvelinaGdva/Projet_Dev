<?php include('menu-front/menu.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des restaurants</title>
    <link rel="stylesheet" href="CSS/restaurants.css">
</head>
<body>

<div class="container">
    <h1>Liste des restaurants</h1>
    <div class="restaurants-list">
        <?php
        include 'Data/database.php';

        $sql_restaurants = "SELECT * FROM restaurant";
        $result_restaurants = $conn->query($sql_restaurants);

        if ($result_restaurants->num_rows > 0) {
            while ($row_restaurant = $result_restaurants->fetch_assoc()) {
                echo "<div class='restaurant'>";
                echo "<h2><a href='restaurant.php?id=" . $row_restaurant['id'] . "'>" . $row_restaurant['restaurant_name'] . "</a></h2>";
                echo "<p>" . $row_restaurant['description'] . "</p>";
                echo "<p>Email: " . $row_restaurant['email'] . "</p>";
                echo "<p>Adresse: " . $row_restaurant['address'] . "</p>";
                echo "<img src='images/logos/" . $row_restaurant['logo'] . "' alt='" . $row_restaurant['restaurant_name'] . "'>";
                echo "</div>";
            }
        } else {
            echo "Aucun restaurant trouvé.";
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
