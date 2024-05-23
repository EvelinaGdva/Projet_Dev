<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Livraisons</title>
    <link rel="stylesheet" href="CSS/delivery.css">
</head>
<body>

<div class="container">
    <h1>Suivi de Livraisons</h1>
    <?php
    include 'Data/database.php';

    function getCurrentDeliveries($conn) {
        $sql = "SELECT * FROM delivery WHERE delivery_date = CURDATE() AND delivery_time >= CURTIME()";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return array();
        }
    }

    function getDeliveryHistory($conn) {
        $sql = "SELECT * FROM delivery WHERE delivery_date < CURDATE() OR (delivery_date = CURDATE() AND delivery_time < CURTIME())";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return array();
        }
    }

    $currentDeliveries = getCurrentDeliveries($conn);
    echo "<h2>Livraisons en cours</h2>";
    if (!empty($currentDeliveries)) {
        echo "<ul>";
        foreach ($currentDeliveries as $delivery) {
            echo "<li>Livraison #" . $delivery['id'] . ", Commande #" . $delivery['id_order'] . ", Date: " . $delivery['delivery_date'] . ", Heure: " . $delivery['delivery_time'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune livraison en cours.";
    }

    $deliveryHistory = getDeliveryHistory($conn);
    echo "<h2>Historique des livraisons</h2>";
    if (!empty($deliveryHistory)) {
        echo "<ul>";
        foreach ($deliveryHistory as $delivery) {
            echo "<li>Livraison #" . $delivery['id'] . ", Commande #" . $delivery['id_order'] . ", Date: " . $delivery['delivery_date'] . ", Heure: " . $delivery['delivery_time'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune livraison dans l'historique.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
