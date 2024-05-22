<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user_role = $_SESSION["user_role"];
if ($user_role != "restaurant" && $user_role != "admin") {
    header("Location: index.php");
    exit;
}

require_once "Data/database.php";

$errors = array();

// Traitement de la suppression du restaurant
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM restaurant WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $success_msg = "Le restaurant a été supprimé avec succès.";
    } else {
        $errors[] = "Une erreur s'est produite lors de la suppression du restaurant.";
    }
}

// Sélection de tous les restaurants
$sql = "SELECT * FROM restaurant";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des restaurants</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
    <h2>Liste des restaurants</h2>
    <?php
    if (isset($success_msg)) {
        echo "<div class='alert alert-success'>$success_msg</div>";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    ?>
    <table>
        <tr>
            <th>Nom du restaurant</th>
            <th>Description</th>
            <th>Adresse</th>
            <?php if ($user_role == "restaurateur") echo "<th>Action</th>"; ?>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["restaurant_name"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                if ($user_role == "admin") {
                    echo "<td><a href='restaurant.php?delete_id=" . $row["id"] . "'>Supprimer</a> | <a href='updateRestaurant.php?update_id=" . $row["id"] . "'>Modifier</a></td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucun restaurant trouvé.</td></tr>";
        }
        ?>
    </table>

   

</body>
</html>
