<?php
session_start();

if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit; 
}

require_once "Data/database.php";

$restaurant_name = "";
$email = "";
$password = "";
$role = "";

if (isset($_POST["register"])) {
    $restaurant_name = isset($_POST["restaurant_name"]) ? $_POST["restaurant_name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $role = isset($_POST["role"]) ? $_POST["role"] : "";

    $errors = [];

    if (empty($email) || empty($password) || empty($role)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if ($role == "restaurant" && empty($restaurant_name)) {
        $errors[] = "Le nom du restaurant est obligatoire pour les restaurateurs.";
    }

    if (empty($errors)) {
        // Assurez-vous que ces informations sont correctes
        $host = "localhost"; 
        $db_username = "root";
        $db_password = "root";
        $database = "evelicious_munch";

$conn = new mysqli($host, $db_username, $db_password, $database);

        if ($conn->connect_error) {
            die("Erreur de connexion: " . $conn->connect_error);
        }

        // Vérifier si l'utilisateur existe déjà
        $sql_check = "SELECT id FROM user WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<div class='alert alert-danger'>Un utilisateur avec cet e-mail existe déjà.</div>";
        } else {
            // Insérer l'utilisateur dans la base de données
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if ($role == "user") {
                $sql_insert = "INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ssss", $username, $email, $hashed_password, $role);
            } elseif ($role == "restaurant") {
                $sql_insert = "INSERT INTO restaurant (restaurant_name, email, password) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("sss", $restaurant_name, $email, $hashed_password);
            }

            if ($stmt_insert->execute()) {
                echo "<div class='alert alert-success'>Inscription réussie. Connectez-vous maintenant.</div>";
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

<form action="#registration" method="post" id="registration">
<link rel="stylesheet" href="CSS/index.css">
    <div class="register"> 
        <h2>INSCRIPTION</h2><br>
        <div class="form-group">
            <label for="role">Choisissez votre rôle :</label>
            <select name="role" id="role" class="form-control">
                <option value="user">Utilisateur</option>
                <option value="restaurant">Restaurateur</option>
            </select>
        </div>
        <div class="form-group" id="username-field" style="display: none;">
            <input type="text" placeholder="Nom d'utilisateur" name="username" class="form-control">
        </div>
        <div class="form-group" id="restaurant-name-field" style="display: none;">
            <input type="text" placeholder="Nom du restaurant" name="restaurant_name" class="form-control" value="<?php echo $restaurant_name; ?>">
        </div>
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe :" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Inscription" name="register" class="btn btn-primary">
        </div>
    </div>
</form>

<script>
    document.getElementById('role').addEventListener('change', function() {
        var selectedRole = this.value;
        var usernameField = document.getElementById('username-field');
        var restaurantNameField = document.getElementById('restaurant-name-field');
        
        if (selectedRole === 'user') {
            usernameField.style.display = 'block';
            restaurantNameField.style.display = 'none';
        } else if (selectedRole === 'restaurant') {
            usernameField.style.display = 'none';
            restaurantNameField.style.display = 'block';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var event = new Event('change');
        document.getElementById('role').dispatchEvent(event);
    });
</script>
