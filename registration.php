<?php

require_once "Data/database.php";

$restaurant_name = "";
$adress = "";
$email = "";
$password = "";
$role = "";
$logo = ""; 

if (isset($_POST["register"])) {
    $restaurant_name = isset($_POST["restaurant_name"]) ? $_POST["restaurant_name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $adress = isset($_POST["adress"]) ? $_POST["adress"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $role = isset($_POST["role"]) ? $_POST["role"] : "";

    // Gestion du téléchargement du logo
    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == UPLOAD_ERR_OK) {
        $logo_tmp_name = $_FILES["logo"]["tmp_name"];
        $logo_name = basename($_FILES["logo"]["name"]);
        $logo_dir = "uploads/logos/";
        $logo_path = $logo_dir . $logo_name;

        // Créer le répertoire de téléchargement s'il n'existe pas
        if (!is_dir($logo_dir)) {
            mkdir($logo_dir, 0777, true);
        }

        // Déplacer le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($logo_tmp_name, $logo_path)) {
            $logo = $logo_path;
        } else {
            $errors[] = "Erreur lors du téléchargement du logo.";
        }
    } else {
        $logo = "uploads/logos/default_logo.png"; // Valeur par défaut si aucun logo n'est téléchargé
    }

    $errors = [];

    if (empty($email) || empty($password) || empty($adress) || empty($role)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if ($role == "restaurant" && (empty($restaurant_name) || empty($adress))) {
        $errors[] = "Le nom du restaurant et l'adresse sont obligatoires pour les restaurateurs.";
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

        $sql_check_restaurant = "SELECT id FROM restaurant WHERE email = ?";
        $stmt_check_restaurant = $conn->prepare($sql_check_restaurant);
        $stmt_check_restaurant->bind_param("s", $email);
        $stmt_check_restaurant->execute();
        $result_check_restaurant = $stmt_check_restaurant->get_result();

        if ($result_check->num_rows > 0 || $result_check_restaurant->num_rows > 0) {
            echo "<div class='alert alert-danger'>Un utilisateur avec cet e-mail existe déjà.</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if ($role == "user") {
                $sql_insert = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("sss", $username, $email, $hashed_password);
            } elseif ($role == "restaurant") {
                $sql_insert = "INSERT INTO restaurant (restaurant_name, adress, email, password, logo) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("sssss", $restaurant_name, $adress, $email, $hashed_password, $logo);
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

<form action="#registration" method="post" id="registration" enctype="multipart/form-data">
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
        <div class="form-group" id="adress-field" style="display: none;">
            <input type="text" placeholder="Adresse" name="adress" class="form-control" value="<?php echo $adress; ?>">
        </div>
        <div class="form-group" id="logo-field" style="display: none;">
            <label for="logo">Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control">
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
        var adressField = document.getElementById('adress-field');
        var logoField = document.getElementById('logo-field');
        
        if (selectedRole === 'user') {
            usernameField.style.display = 'block';
            restaurantNameField.style.display = 'none';
            adressField.style.display = 'none';
            logoField.style.display = 'none';
        } else if (selectedRole === 'restaurant') {
            usernameField.style.display = 'none';
            restaurantNameField.style.display = 'block';
            adressField.style.display = 'block';
            logoField.style.display = 'block';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var event = new Event('change');
        document.getElementById('role').dispatchEvent(event);
    });
</script>
