<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="login_page.css">
</head>
<body>

<div class="login-container">
    <h2>Connexion</h2>
    <form action="process_login.php" method="post">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Type de compte</label>
            <select id="role" name="role" required>
                <option value="membre">Membre</option>
                <option value="restaurateur">Restaurateur</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Se connecter</button>
        </div>
    </form>
</div>

</body>
</html>
