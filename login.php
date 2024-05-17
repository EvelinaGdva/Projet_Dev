<?php
session_start();

if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href='../CSS/index.css' rel="stylesheet">
</head>

<body>
    <div class="container login-container">
        <?php
        require_once "Data/database.php"; // Inclure le fichier contenant les informations de la base de données

        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $conn = new mysqli($host, $db_username, $db_password, $database);

            $sql = "SELECT id, password FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = $user["id"];
                    header("Location: index.php");
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Le nom d'utilisateur ou le mot de passe est incorrect.</div>";
                }
            } else {
                // Créer automatiquement un compte pour cet utilisateur
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert = "INSERT INTO user (username, password) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ss", $username, $hashed_password);
                $stmt_insert->execute();
                
                // Informez l'utilisateur que son compte a été créé avec succès
                echo "<div class='alert alert-success'>Votre compte a été créé avec succès. Connectez-vous maintenant.</div>";
            }
        }
        ?>

        <form action="login.php" method="post">
            <div class="login"> 
                <h2>CONNEXION</h2><br>
                <div class="form-group">
                    <input type="username" placeholder="Entrez votre nom d'utilisateur :" name="username" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Entrez votre mot de passe :" name="password" class="form-control">
                </div>
                <div class="form-btn">
                    <input type="submit" value="Connexion" name="login" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
