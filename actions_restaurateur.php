<?php
// Assurez-vous que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si une image a été téléchargée
    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] === UPLOAD_ERR_OK) {
        // Le fichier a été téléchargé avec succès
        $image = $_FILES['food_image']['name'];
        // Emplacement temporaire du fichier téléchargé
        $image_tmp = $_FILES['food_image']['tmp_name'];
        // Emplacement où vous souhaitez enregistrer l'image
        $upload_directory = 'uploads/'; // Assurez-vous que ce répertoire existe
        // Déplacer le fichier téléchargé vers le répertoire de destination
        move_uploaded_file($image_tmp, $upload_directory . $image);
    } else {
        // Aucun fichier n'a été téléchargé ou une erreur est survenue lors du téléchargement
        // Gérez cette condition en affichant un message à l'utilisateur ou en arrêtant le processus
        echo "Veuillez sélectionner une image.";
        exit; // Arrêtez l'exécution du script car une image est requise
    }

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

    // Récupérer les données du formulaire
    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_price = $_POST['food_price'];

    // Préparer la requête d'insertion avec une requête préparée pour éviter les attaques par injection SQL
    $sql = "INSERT INTO food (image, food_name, food_description, food_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $image, $food_name, $food_description, $food_price);

    // Exécuter la requête d'insertion
    if ($stmt->execute()) {
        header("Location: gestion_restaurateur.php");
    } else {
        echo "Erreur lors de l'ajout du plat: " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
