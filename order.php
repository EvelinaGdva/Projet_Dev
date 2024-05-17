<?php include('menu-front/menu.php'); ?>

<?php 
session_start();
require_once "Data/database.php";

if(isset($_GET['food_id']))
{
    $food_id = $_GET['food_id'];

    $sql = "SELECT * FROM food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count==1)
    {
        $row = mysqli_fetch_assoc($res);

        $id = $row['id'];
        $price_of_order = $row['price_of_order'];
        $image = $row['image'];
    }
    else
    {
        header('location:');
        exit;
    }
}
else
{
    header('location:');
    exit;
}
?>

<section class="food-search">
    <div class="container">
        
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php                     
                    if($image=="")
                    {
                        echo "<div class='error'>Image not Available.</div>";
                    }
                    else
                    {                         
                        ?>
                        <img src="images/food/<?php echo $image; ?>" alt="" class="img-responsive img-curve">
                        <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $row['food_name']; ?></h3>
                    <input type="hidden" name="food_name" value="<?php echo $row['food_name']; ?>">
                    <p class="price">$<?php echo $price_of_order; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price_of_order; ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="" class="input-responsive" required>
                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="" class="input-responsive" required>
                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="" class="input-responsive" required>
                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="" class="input-responsive" required></textarea>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php 
       
            if(isset($_POST['submit']))
            {
                $food_name = $_POST['food_name'];
                $food_price = $_POST['price'];
                $quantity = $_POST['qty'];
                $total = intval($food_price) * intval($quantity);
                $order_date = date("Y-m-d h:i:sa"); //Order Date
                $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled
            
                // Insertion de la commande dans la base de données
                $sql = "INSERT INTO `order` (food_name, price, quantity, total, order_date, status) VALUES ('$food_name', $food_price, $quantity, $total, '$order_date', '$status')";
            
                $sql = "SELECT * FROM `order`";
                $res = mysqli_query($conn, $sql);
            
                if($res)
                {
                    // La commande a été insérée avec succès
                    $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                    header('location: index.php'); // Rediriger vers la page d'accueil ou une autre page après avoir passé la commande
                    exit;
                }
                else
                {
                    // Erreur lors de l'insertion de la commande
                    $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                    header('location: order.php'); // Rediriger vers la page de commande pour réessayer
                    exit;
                }
            }
                    
        ?>
    </div>
</section>
