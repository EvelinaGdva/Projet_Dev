<?php
session_start();

//connexion à la base de données
$host = "localhost"; 
$db_username = "root";
$db_password = "root";
$database = "evelicious_munch";
$port = 8888;

$conn = new mysqli($host, $db_username, $db_password, $database, $port);

/// Vérifier si les données nécessaires sont fournies
if (isset($_POST['id'], $_POST['restaurant_name'], $_POST['password'], $_POST['email'], $_POST['adress'], $_POST['logo'])) {
    $plat_id = $_POST['id'];
    $restaurant_name = $_POST['restaurant_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $adress = $_POST['adress'];
    $logo = $_POST['logo'];

} else {
    echo "Aucune information trouvée pour ce restaurant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Restaurateur</title>
    <link rel="stylesheet" href="CSS/gestion_restaurateur.css">
</head>
<body>

<div class="container">
    <h1>Informations du Restaurant</h1>
    <form action="Controller/update_restaurant.php" method="post">
        <div class="form-group">
            <label for="restaurant_name">Nom du restaurant:</label>
            <input type="text" id="restaurant_name" name="restaurant_name" value="<?php echo $restaurant_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>
        <div class="form-group">
            <label for="logo">Logo:</label>
            <input type="file" id="logo" name="logo" accept="image/*">
            <img src="<?php echo $logo; ?>" alt="Logo du restaurant" width="100">
        </div>
        <div class="form-group">
            <input type="submit" value="Mettre à jour" name="update" class="btn btn-primary">
        </div>
    </form>
</div>

</body>
</html>
