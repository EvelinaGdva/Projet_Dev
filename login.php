<?php
require_once "Data/database.php";

$username = "";
$email = "";
$restaurant_name = "";

if (isset($_POST["login"])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $role = isset($_POST["role"]) ? $_POST["role"] : "";

    // Set restaurant_name only if the role is 'restaurant'
    if ($role == "restaurant") {
        $restaurant_name = isset($_POST["restaurant_name"]) ? $_POST["restaurant_name"] : "";
    }

    $conn = new mysqli($host, $db_username, $db_password, $database);

    if ($role == "user") {
        $sql = "SELECT id, password FROM user WHERE username = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $role);
    } elseif ($role == "restaurant") {
        $sql = "SELECT id, password FROM restaurant WHERE restaurant_name = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $restaurant_name, $email);
    } elseif ($role == "admin") {
        $predefined_email = "admin@eveliciousmunch.com";
        $predefined_password = md5("admin"); 
        if ($email === $predefined_email && md5($password) === $predefined_password) {
            $_SESSION["user"] = "admin";
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Identifiants administrateur incorrects.</div>";
            exit;
        }
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["id"];
            if ($role == "user") {
                header("Location: userProfil.php");
            } elseif ($role == "restaurant") {
                header("Location: restaurant.php");
            }
            exit;
        } else {
            echo "<div class='alert alert-danger'>Le nom d'utilisateur ou le mot de passe est incorrect.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Aucun utilisateur trouvé avec ce rôle.</div>";
    }
}
?>

<form action="login.php" method="post">
    <link rel="stylesheet" href="CSS/index.css">
    <div class="login"> 
        <h2>CONNEXION</h2><br>
        <div class="form-group">
            <label for="role">Choisissez votre rôle :</label>
            <select name="role" id="role" class="form-control">
                <option value="user" <?php if ($role == "user") echo "selected"; ?>>Utilisateur</option>
                <option value="admin" <?php if ($role == "admin") echo "selected"; ?>>Administrateur</option>
                <option value="restaurant" <?php if ($role == "restaurant") echo "selected"; ?>>Restaurateur</option>
            </select>
        </div>
        <div class="form-group" id="username-field">
            <input type="text" placeholder="<?php echo ($role == 'restaurant') ? 'Nom du restaurateur' : 'Nom d\'utilisateur'; ?>" name="username" class="form-control" value="<?php echo $username; ?>">
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
            <input type="submit" value="Connexion" name="login" class="btn btn-primary">
            <p>Vous n'avez pas de compte ? <a href="registration.php">Inscrivez-vous ici</a>.</p>
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
