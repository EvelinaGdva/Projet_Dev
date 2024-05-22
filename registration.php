<?php
session_start();

if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit; 
}

require_once "Data/database.php";

$username = "";
$email = "";
$password = "";
$role = "";
$restaurant_name = ""; // Ajout de cette ligne pour initialiser la variable

if (isset($_POST["register"])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $role = isset($_POST["role"]) ? $_POST["role"] : "";

    // Set restaurant_name seulement si le rôle est "restaurateur"
    if ($role == "restaurant") {
        $restaurant_name = isset($_POST["restaurant_name"]) ? $_POST["restaurant_name"] : "";
    }


    $conn = new mysqli($host, $db_username, $db_password, $database);

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
        } elseif ($role == "admin") {
            $sql_insert = "INSERT INTO admin (email, password) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ss", $email, $hashed_password);
        }

        if ($stmt_insert->execute()) {
            echo "<div class='alert alert-success'>Inscription réussie. Connectez-vous maintenant.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'inscription. Veuillez réessayer.</div>";
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
        <div class="form-group" id="username-field">
            <input type="text" placeholder="Nom d'utilisateur" name="username" class="form-control" value="<?php echo $username; ?>">
        </div>
        <?php if ($role == "restaurant"): ?>
        <div class="form-group">
            <input type="text" placeholder="Nom du restaurant" name="restaurant_name" class="form-control" value="<?php echo $restaurant_name; ?>">
        </div>
        <?php endif; ?>
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
        var emailField = document.getElementById('email-field');
        
        if (selectedRole === 'user' || selectedRole === 'restaurant') {
            usernameField.style.display = 'block';
            <?php if ($role == "restaurant"): ?>
            restaurantNameField.style.display = 'block';
            <?php endif; ?>
            emailField.style.display = 'block';
        } else {
            usernameField.style.display = 'none';
            <?php if ($role == "restaurant"): ?>
            restaurantNameField.style.display = 'none';
            <?php endif; ?>
            emailField.style.display = 'block';
        }
    });
</script>
   