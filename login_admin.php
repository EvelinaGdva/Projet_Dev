<?php
session_start();

// Définir les identifiants de l'administrateur
$admin_username = "admin";
$admin_password = "admin";

// Vérifier si le formulaire de connexion est soumis
if (isset($_POST["login"])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $errors = [];

    if (empty($username) || empty($password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    // Vérification des identifiants de l'administrateur
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: interface_admin.php");
        exit;
    } else {
        $errors[] = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    // Afficher les erreurs
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login">
    <link rel="stylesheet" href="CSS/index.css">
    <div class="login"> 
        <h2>Connexion en tant qu'Admin</h2><br>
        <div class="form-group" id="username-field">
            <input type="username" placeholder="username" name="username" class="form-control" value="<?php echo isset($username) ? $username : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Mot de passe" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Connexion" name="login" class="btn btn-primary">
        </div>
    </div>
</form>
