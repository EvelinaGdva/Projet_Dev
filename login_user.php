<?php

require_once "Data/database.php";

$email = "";
$password = "";

if (isset($_POST["login"])) {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $errors = [];

    if (empty($email) || empty($password)) {
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

        $sql_check = "SELECT id, password FROM user WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 1) {
            $user = $result_check->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                echo "<div class='alert alert-success'>Connexion réussie. Bienvenue!</div>";
                header("Location: index_user.php");
            } else {
                echo "<div class='alert alert-danger'>Mot de passe incorrect.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Aucun utilisateur trouvé avec cet e-mail.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>


<form action="#login" method="post" id="login" enctype="multipart/form-data">
    <link rel="stylesheet" href="CSS/index.css">
    <div class="register"> 
        <h2>Connexion en tant qu'utilisateur</h2><br>
        
        
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Connexion" name="login" class="btn btn-primary">
        </div>
        <div class="form-link">
            <a href="registration_user.php">Inscrivez-vous ici</a>
        </div>
    </div>
</form>
