<?php
include 'Data/database.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_name = $_POST['restaurant_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id FROM restaurant WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Cet email est déjà utilisé pour un autre compte.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO restaurant (restaurant_name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $restaurant_name, $email, $hashed_password);
        if ($stmt->execute()) {
            header("Location: loginRestaurant.php");
            exit();
        } else {
            $error = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Restaurateur</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <div class="login-container">
        <h2>Inscription Restaurateur</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="registrationRestaurant.php">
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
            <button type="submit">S'inscrire</button>
            <p>Déjà un compte ? <a href="loginRestaurant.php">Connectez-vous ici</a>.</p>
        </form>
    </div>
</body>
</html>
