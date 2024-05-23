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

        // Utilisation des requêtes préparées pour éviter les injections SQL
        $sql_check_restaurant = "SELECT id, password FROM restaurant WHERE email = ?";
        $stmt_check_restaurant = $conn->prepare($sql_check_restaurant);
        $stmt_check_restaurant->bind_param("s", $email);
        $stmt_check_restaurant->execute();
        $result_check_restaurant = $stmt_check_restaurant->get_result();

        if ($result_check_restaurant->num_rows > 0) {
            // Récupération du mot de passe haché depuis la base de données
            $row = $result_check_restaurant->fetch_assoc();
            $hashed_password = $row['password'];

            // Vérification du mot de passe
            if (password_verify($password, $hashed_password)) {
                header("Location: gestion_restaurateur.php");
                exit(); // Assure que le script s'arrête après la redirection
            } else {
                echo "<div class='alert alert-danger'>Email ou mot de passe incorrect.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email ou mot de passe incorrect.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<form action="#login" method="post" id="login">
    <link rel="stylesheet" href="CSS/index.css">
    <div class="login"> 
        <h2>Connexion en tant que restaurateur</h2><br>
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Mot de passe" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Connexion" name="login" class="btn btn-primary">
        </div>
        <div class="form-link">
            <a href="registration_restaurateur.php">Inscrivez-vous ici</a>
        </div>
    </div>
</form>
