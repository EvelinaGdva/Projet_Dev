<?php
include 'Data/database.php';

session_start();
$userId = $_SESSION['user_id'];

function getCurrentCart($conn, $userId) {
    $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getPendingOrders($conn, $userId) {
    $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getOrderHistory($conn, $userId) {
    $sql = "SELECT * FROM `order` WHERE id_user = ? AND status = 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$currentCart = getCurrentCart($conn, $userId);

$pendingOrders = getPendingOrders($conn, $userId);

$orderHistory = getOrderHistory($conn, $userId);

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

$conn->close();
?>
