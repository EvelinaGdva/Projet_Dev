<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Livraisons</title>
    <link rel="stylesheet" href="CSS/delivery.css">
</head>
<body>
    <div class="menu-container">
        <?php
        include 'menu-front/menu.php';
        ?>
    </div>
    <div class="content-container">
        <?php
        include 'Data/database.php';

        session_start();

        // Fonction pour récupérer les livraisons en cours
        function getCurrentDeliveries($conn) {
            $sql = "SELECT * FROM delivery WHERE delivery_date = CURDATE() AND delivery_time >= CURTIME()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Fonction pour récupérer l'historique des livraisons
        function getDeliveryHistory($conn) {
            $sql = "SELECT * FROM delivery WHERE delivery_date < CURDATE() OR (delivery_date = CURDATE() AND delivery_time < CURTIME())";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        $currentDeliveries = getCurrentDeliveries($conn);
        $deliveryHistory = getDeliveryHistory($conn);
        ?>
        
        <h2>Livraisons en cours</h2>
        <?php if (!empty($currentDeliveries)) : ?>
            <ul>
                <?php foreach ($currentDeliveries as $delivery) : ?>
                    <li>
                        Livraison #<?php echo htmlspecialchars($delivery['id']); ?>, Commande #<?php echo htmlspecialchars($delivery['id_order']); ?>, Date: <?php echo htmlspecialchars($delivery['delivery_date']); ?>, Heure: <?php echo htmlspecialchars($delivery['delivery_time']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-deliveries">Aucune livraison en cours.</p>
        <?php endif; ?>

        <h2>Historique des livraisons</h2>
        <?php if (!empty($deliveryHistory)) : ?>
            <ul>
                <?php foreach ($deliveryHistory as $delivery) : ?>
                    <li>
                        Livraison #<?php echo htmlspecialchars($delivery['id']); ?>, Commande #<?php echo htmlspecialchars($delivery['id_order']); ?>, Date: <?php echo htmlspecialchars($delivery['delivery_date']); ?>, Heure: <?php echo htmlspecialchars($delivery['delivery_time']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-deliveries">Aucune livraison dans l'historique.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
