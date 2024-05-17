<?php
require_once "Data/database.php";

if(isset($_POST['submit'])) {
    $id_restaurant = $_POST['restaurant'];
    $id_user = $_POST['user'];
    $food_name = $_POST['food_name'];
    $price_of_order = $_POST['food_price'];
    $quantity = $_POST['quantity'];
    $total = $price_of_order * $quantity;
    $order_date = date("Y-m-d H:i:s"); 
    $status = "Ordered"; 
    
    $sql = "INSERT INTO `order` (id_restaurant, id_user, food_name, price_of_order, quantity, total, order_date, status) 
    VALUES ('$id_restaurant', '$id_user', '$food_name', '$price_of_order', '$quantity', '$total', '$order_date', '$status')";

    
    if(mysqli_query($conn, $sql)) {
        echo "<div class='success'>La commande a été passée avec succès.</div>";
    } else {
        echo "<div class='error'>Erreur lors du traitement de la commande: " . mysqli_error($conn) . "</div>";
    }
} else {
    header("Location: order.php");
    exit();
}
?>
