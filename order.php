<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="CSS/order.css">
</head>
<body>
    <?php
    include 'Data/database.php';
    include 'menu-front/menu.php';

    session_start();
    $userId = $_SESSION['user_id'];

    // Fonction pour récupérer le panier actuel de l'utilisateur
    function getCurrentCart($conn, $userId) {
        $sql = "SELECT id, id_user, id_restaurant, id_food, order_date, order_time, price_of_order, total, status FROM `order` WHERE id_user = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fonction pour récupérer les commandes en cours de l'utilisateur
    function getPendingOrders($conn, $userId) {
        $sql = "SELECT id, id_user, id_restaurant, id_food, order_date, order_time, price_of_order, total, status FROM `order` WHERE id_user = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fonction pour récupérer l'historique des commandes de l'utilisateur
    function getOrderHistory($conn, $userId) {
        $sql = "SELECT id, id_user, id_restaurant, id_food, order_date, order_time, price_of_order, total, status FROM `order` WHERE id_user = ? AND status = 'completed'";
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
    echo "<div class='container'>";
    echo "<h2>Votre Panier Actuel</h2>";
    if (!empty($currentCart)) {
        echo "<ul>";
        foreach ($currentCart as $item) {
            echo "<li>Produit #" . htmlspecialchars($item['id_food']) . ", Prix: " . htmlspecialchars($item['price_of_order']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='no-orders'>Votre panier est vide.</p>";
    }

    // Affichage des commandes en cours de l'utilisateur
    echo "<h2>Commandes en cours</h2>";
    if (!empty($pendingOrders)) {
        echo "<ul>";
        foreach ($pendingOrders as $order) {
            echo "<li>Commande #" . htmlspecialchars($order['id']) . ", Date: " . htmlspecialchars($order['order_date']) . ", Heure: " . htmlspecialchars($order['order_time']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='no-orders'>Aucune commande en cours.</p>";
    }

    // Affichage de l'historique des commandes de l'utilisateur
    echo "<h2>Historique des commandes</h2>";
    if (!empty($orderHistory)) {
        echo "<ul>";
        foreach ($orderHistory as $order) {
            echo "<li>Commande #" . htmlspecialchars($order['id']) . ", Date: " . htmlspecialchars($order['order_date']) . ", Heure: " . htmlspecialchars($order['order_time']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='no-orders'>Aucune commande dans l'historique.</p>";
    }

    echo "</div>";
    $conn->close();
    ?>
</body>
</html>
