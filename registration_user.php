<?php

require_once "Data/database.php";

$email = "";
$username  = "";
$password = "";

if (isset($_POST["register"])) {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $errors = [];

    if (empty($email) || empty($password) || empty($username)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (empty($errors)) {
        $host = "localhost";
        $db_username = "root";
        $db_password = "root";
        $database = "evelicious_munch";
        $port = 8888;

        $conn = new mysqli($host, $db_username, $db_password, $database, $port);

        if ($conn->connect_error) {
            die("Erreur de connexion: " . $conn->connect_error);
        }

        $sql_check = "SELECT id FROM user WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<div class='alert alert-danger'>Un utilisateur avec cet e-mail existe déjà.</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO user (email, username, password, sold) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $sold = 0; // Définir une valeur par défaut pour 'sold'
            $stmt_insert->bind_param("sssi", $email, $username, $hashed_password, $sold);

            if ($stmt_insert->execute()) {
                echo "<div class='alert alert-success'>Inscription réussie. Connectez-vous maintenant.</div>";
                header("Location: login_user.php");
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de l'inscription. Veuillez réessayer.</div>";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>


<form action="#registration" method="post" id="registration" enctype="multipart/form-data">
    <link rel="stylesheet" href="CSS/index.css">
    <div class="register"> 
        <h2>INSCRIPTION</h2><br>
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group" id="usename-field">
            <input type="text" placeholder="Username" name="username" class="form-control" value="<?php echo $username; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Inscription" name="register" class="btn btn-primary">
        </div>
    </div>
</form>
