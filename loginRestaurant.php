<?php
include 'Data/database.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_name = $_POST['restaurant_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête SQL
    $stmt = $conn->prepare("SELECT * FROM restaurant WHERE restaurant_name = ? AND email = ?");
    $stmt->bind_param("ss", $restaurant_name, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurant = $result->fetch_assoc();

    // Vérifier si le restaurant existe et si le mot de passe est correct
    if ($restaurant && password_verify($password, $restaurant['password'])) {
        session_start();
        $_SESSION['restaurant_id'] = $restaurant['id'];
        $_SESSION['restaurant_name'] = $restaurant['restaurant_name'];
        header("Location: indexRestaurateur.php");
        exit();
    } else {
        $error = "Nom du restaurant, email ou mot de passe incorrect.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Restaurateur</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion Restaurateur</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="loginRestaurant.php">
            <div class="form-group">
                <label for="restaurant_name">Nom du restaurant:</label>
                <input type="text" id="restaurant_name" name="restaurant_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
            <p>Vous n'avez pas de compte ? <a href="registrationRestaurant.php">Inscrivez-vous ici</a>.</p>
        </form>
    </div>
</body>
</html>
