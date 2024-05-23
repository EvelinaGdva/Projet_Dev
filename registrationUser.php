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
    <title>Inscription</title>
    <link href='../CSS/index.css' rel="stylesheet">
</head>

<body>
    <div class="container login-container">
        <?php
        require_once "Data/database.php"; // Inclure le fichier contenant les informations de la base de données

        if (isset($_POST["register"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            $email = $_POST["email"]; // Ajout de cette ligne pour récupérer l'email

            if ($password !== $confirm_password) {
                echo "<div class='alert alert-danger'>Les mots de passe ne correspondent pas.</div>";
            } else {
                $conn = new mysqli($host, $db_username, $db_password, $database);

                // Vérifier si le nom d'utilisateur existe déjà
                $sql_check = "SELECT id FROM user WHERE username = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("s", $username);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();

                if ($result_check->num_rows > 0) {
                    echo "<div class='alert alert-danger'>Le nom d'utilisateur est déjà pris.</div>";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_insert = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("sss", $username, $hashed_password, $email); // Modification de cette ligne pour inclure l'email
                    $stmt_insert->execute();

                    if ($stmt_insert->affected_rows > 0) {
                        echo "<div class='alert alert-success'>Votre compte a été créé avec succès. Redirection vers <a href='login.php'>la page de connexion</a>...</div>";
                        // Redirection vers la page de connexion après 2 secondes
                        header("refresh:2; url=loginUser.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.</div>";
                    }
                }
            }
        }
        ?>

        <form action="registrationUser.php" method="post">
            <div class="login"> 
                <h2>INSCRIPTION</h2><br>
                <div class="form-group">
                    <input type="text" placeholder="Entrez votre nom d'utilisateur :" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Entrez votre mot de passe :" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirmez votre mot de passe :" name="confirm_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Entrez votre email :" name="email" class="form-control" required>
                </div>
                <div class="form-btn">
                    <input type="submit" value="Inscription" name="register" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>
