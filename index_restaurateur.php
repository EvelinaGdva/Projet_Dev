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
    <form action="actions_restaurateur.php" method="post" enctype="multipart/form-data">
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
    <a href="gestion_restaurateur.php" class="btn-view-plats">Voir les plats</a>
</div>

<div class="food">

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

    // Traitement du formulaire d'ajout de plat
    if (isset($_POST["food_name"], $_POST["food_description"], $_POST["food_price"])) {
        $food_name = $_POST["food_name"];
        $food_description = $_POST["food_description"];
        $food_price = $_POST["food_price"];

        // Traitement du téléchargement de l'image (vous pouvez ajouter cette partie si nécessaire)

        // Requête SQL pour insérer le plat dans la base de données
        $sql = "INSERT INTO food (food_name, food_description, food_price) VALUES ('$food_name', '$food_description', '$food_price')";

        if ($conn->query($sql) === TRUE) {
            // Redirection vers la même page après l'ajout du plat
            header("Location: gestion_restaurateur.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout du plat: " . $conn->error;
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>

</div>

</body>
</html>
