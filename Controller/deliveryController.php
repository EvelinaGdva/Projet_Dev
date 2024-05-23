<?php
include 'Data/database.php';

function getDeliveryConfig($conn) {
    $sql = "SELECT * FROM delivery_config";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function updateDeliveryConfig($conn, $config) {
    $sql = "UPDATE delivery_config SET delivery_fee = ?, free_delivery_threshold = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $config['delivery_fee'], $config['free_delivery_threshold']);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$currentConfig = getDeliveryConfig($conn);
if ($currentConfig) {
    echo "<h2>Configuration actuelle de livraison</h2>";
    echo "<p>Frais de livraison: " . $currentConfig['delivery_fee'] . "</p>";
    echo "<p>Seuil de livraison gratuite: " . $currentConfig['free_delivery_threshold'] . "</p>";
} else {
    echo "Aucune configuration de livraison trouvée.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deliveryFee = $_POST['delivery_fee'];
    $freeDeliveryThreshold = $_POST['free_delivery_threshold'];

    $updatedConfig = array(
        'delivery_fee' => $deliveryFee,
        'free_delivery_threshold' => $freeDeliveryThreshold
    );
    if (updateDeliveryConfig($conn, $updatedConfig)) {
        echo "<p class='success'>Configuration de livraison mise à jour avec succès.</p>";
    } else {
        echo "<p class='error'>Erreur lors de la mise à jour de la configuration de livraison.</p>";
    }
}
?>

<h2>Modifier la configuration de livraison</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
        <label for="delivery_fee">Frais de livraison:</label>
        <input type="number" name="delivery_fee" value="<?php echo $currentConfig['delivery_fee']; ?>" required>
    </div>
    <div class="form-group">
        <label for="free_delivery_threshold">Seuil de livraison gratuite:</label>
        <input type="number" name="free_delivery_threshold" value="<?php echo $currentConfig['free_delivery_threshold']; ?>" required>
    </div>
    <button type="submit">Enregistrer</button>
</form>
