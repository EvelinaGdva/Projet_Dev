<?php
// Vérifier si l'ID du plat est fourni
if (isset($_GET['id'])) {
    $plat_id = $_GET['id'];

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

    // Récupérer les informations du plat
    $sql = "SELECT * FROM food WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $plat_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $plat = $result->fetch_assoc();
    } else {
        echo "Plat non trouvé.";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID du plat non fourni.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le plat</title>
    <link rel="stylesheet" href="../CSS/update_food.css">
</head>
<body>

<div class="container">
    <h1>Modifier le plat</h1>
    <form action="update_food_process_admin.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $plat['id']; ?>">

        <label for="food_name">Nom du plat:</label><br>
        <input type="text" id="food_name" name="food_name" value="<?php echo $plat['food_name']; ?>" required><br><br>

        <label for="food_image">Image:</label><br>
        <input type="file" id="food_image" name="food_image" accept="image/*"><br><br>
        <img src="../images/food/<?php echo $plat['image']; ?>" alt="<?php echo $plat['food_name']; ?>" style="max-width: 200px;"><br><br>

        <label for="food_description">Description:</label><br>
        <textarea id="food_description" name="food_description" required><?php echo $plat['food_description']; ?></textarea><br><br>

        <label for="food_price">Prix:</label><br>
        <input type="number" id="food_price" name="food_price" min="0" step="0.01" value="<?php echo $plat['food_price']; ?>" required><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</div>

</body>
</html>
