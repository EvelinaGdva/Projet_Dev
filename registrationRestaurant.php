<?php

require_once "Data/database.php";

$restaurant_name = "";
$address = "";
$email = "";
$password = "";
$logo = ""; 

if (isset($_POST["register"])) {
    $restaurant_name = isset($_POST["restaurant_name"]) ? $_POST["restaurant_name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $adress = isset($_POST["adress"]) ? $_POST["adress"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == UPLOAD_ERR_OK) {
        $logo_tmp_name = $_FILES["logo"]["tmp_name"];
        $logo_name = basename($_FILES["logo"]["name"]);
        $logo_dir = "uploads/logos/";
        $logo_path = $logo_dir . $logo_name;

        if (!is_dir($logo_dir)) {
            mkdir($logo_dir, 0777, true);
        }

        if (move_uploaded_file($logo_tmp_name, $logo_path)) {
            $logo = $logo_path;
        } else {
            $errors[] = "Erreur lors du téléchargement du logo.";
        }
    } else {
        $logo = "uploads/logos/default_logo.png"; 
    }

    $errors = [];

    if (empty($email) || empty($password) || empty($adress) || empty($restaurant_name)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (empty($errors)) {
        $host = "localhost"; 
        $db_username = "root";
        $db_password = "root";
        $database = "Evelicious_munch";
        $port = 8887;

        $conn = new mysqli($host, $db_username, $db_password, $database, $port);

        if ($conn->connect_error) {
            die("Erreur de connexion: " . $conn->connect_error);
        }

        $sql_check_restaurant = "SELECT id FROM restaurant WHERE email = ?";
        $stmt_check_restaurant = $conn->prepare($sql_check_restaurant);
        $stmt_check_restaurant->bind_param("s", $email);
        $stmt_check_restaurant->execute();
        $result_check_restaurant = $stmt_check_restaurant->get_result();

        if ($result_check_restaurant->num_rows > 0) {
            echo "<div class='alert alert-danger'>Un restaurateur avec cet e-mail existe déjà.</div>";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO restaurant (restaurant_name, address, email, password, logo, description) VALUES (?, ?, ?, ?, ?, '')";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sssss", $restaurant_name, $address, $email, $hashed_password, $logo);
            

            if ($stmt_insert->execute()) {
                echo "<div class='alert alert-success'>Inscription réussie. Connectez-vous maintenant.</div>";
                header("Location: loginRestaurant.php");
                exit(); 
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
        <h2>Inscription Restaurateur</h2><br>
        <div class="form-group" id="restaurant-name-field">
            <input type="text" placeholder="Nom du restaurant" name="restaurant_name" class="form-control">
        </div>
        <div class="form-group" id="adress-field">
            <input type="text" placeholder="Adresse" name="adress" class="form-control">
        </div>
        <div class="form-group" id="logo-field">
            <label for="logo">Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>
        <div class="form-group" id="email-field">
            <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Inscription" name="register" class="btn btn-primary">
        </div>
    </div>
</form>