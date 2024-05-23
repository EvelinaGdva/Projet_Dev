<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['food_image']['name'];
        $image_tmp = $_FILES['food_image']['tmp_name'];
        $upload_directory = 'uploads/'; 
        move_uploaded_file($image_tmp, $upload_directory . $image);
    } else {
        echo "Veuillez sélectionner une image.";
        exit; 
    }

    $host = "localhost"; 
    $db_username = "root";
    $db_password = "root";
    $database = "Evelicious_munch";
    $port = 8887;

    $conn = new mysqli($host, $db_username, $db_password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_price = $_POST['food_price'];

    $sql = "INSERT INTO food (image, food_name, food_description, food_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $image, $food_name, $food_description, $food_price);

    if ($stmt->execute()) {
        header("Location: restaurantController.php");
    } else {
        echo "Erreur lors de l'ajout du plat: " . $conn->error;
    }

    $conn->close();
}
?>