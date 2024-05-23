<?php
// Vérifier si les données nécessaires sont fournies
if (isset($_POST['id'], $_POST['food_name'], $_POST['food_description'], $_POST['food_price'])) {
    $plat_id = $_POST['id'];
    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_price = $_POST['food_price'];

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

    // Vérifier si une nouvelle image a été téléchargée
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['food_image']['name'];
        $target_directory = "../images/food/";
        $target_file = $target_directory . basename($image);
        move_uploaded_file($_FILES['food_image']['tmp_name'], $target_file);

        // Requête SQL pour mettre à jour le plat avec une nouvelle image
        $sql = "UPDATE food SET food_name = ?, food_description = ?, food_price = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $food_name, $food_description, $food_price, $image, $plat_id);
    } else {
        // Requête SQL pour mettre à jour le plat sans changer l'image
        $sql = "UPDATE food SET food_name = ?, food_description = ?, food_price = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $food_name, $food_description, $food_price, $plat_id);
    }

    if ($stmt->execute()) {
        // Redirection vers la page de gestion après la mise à jour
        header("Location: ../intarface_admin.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du plat: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Données nécessaires non fournies.";
}
?>
