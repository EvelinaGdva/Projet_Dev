<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre titre</title>
    <link rel="stylesheet" href="order.css">
</head>
<body>
    <?php
    include 'Data/database.php';
    include 'menu-front/menu.php';

    session_start();
    $userId = $_SESSION['user_id'];

    // Fonction pour récupérer le panier actuel de l'utilisateur
    function getCurrentCart($conn, $userId) {
        $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fonction pour récupérer les commandes en cours de l'utilisateur
    function getPendingOrders($conn, $userId) {
        $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fonction pour récupérer l'historique des commandes de l'utilisateur
    function getOrderHistory($conn, $userId) {
        $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Récupération du panier actuel de l'utilisateur
    $currentCart = getCurrentCart($conn, $userId);

    // Récupération des commandes en cours de l'utilisateur
    $pendingOrders = getPendingOrders($conn, $userId);

    // Récupération de l'historique des commandes de l'utilisateur
    $orderHistory = getOrderHistory($conn, $userId);

    // Affichage du panier actuel de l'utilisateur
    echo "<h2>Votre Panier Actuel</h2>";
    if (!empty($currentCart)) {
        echo "<ul>";
        foreach ($currentCart as $item) {
            echo "<li>Produit #" . $item['id_food'] . ", Prix: " . $item['price_of_order'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Votre panier est vide.";
    }

    // Affichage des commandes en cours de l'utilisateur
    echo "<h2>Commandes en cours</h2>";
    if (!empty($pendingOrders)) {
        echo "<ul>";
        foreach ($pendingOrders as $order) {
            echo "<li>Commande #" . $order['id'] . ", Date: " . $order['order_date'] . ", Heure: " . $order['order_time'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune commande en cours.";
    }

    // Affichage de l'historique des commandes de l'utilisateur
    echo "<h2>Historique des commandes</h2>";
    if (!empty($orderHistory)) {
        echo "<ul>";
        foreach ($orderHistory as $order) {
            echo "<li>Commande #" . $order['id'] . ", Date: " . $order['order_date'] . ", Heure: " . $order['order_time'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune commande dans l'historique.";
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>
