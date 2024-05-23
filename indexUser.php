<?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <form action="food-search.php" method="POST">
            <link rel="stylesheet" href="CSS/indexUser.css">
            <input type="search" name="search" placeholder="Rechercher des plats.." required>
            <input type="submit" name="submit" value="Rechercher" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="options text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <div class="col-md-4">
                        <a href="restaurants.php">
                            <img src="Images/restaurant.png" alt="Restaurants" class="img-responsive img-curve">
                            <h3>Restaurants</h3>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="order.php">
                            <img src="Images/order.png" alt="Order" class="img-responsive img-curve">
                            <h3>Commandes</h3>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="delivery.php">
                            <img src="Images/delivery.png" alt="Delivery" class="img-responsive img-curve">
                            <h3>Livraison</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
    if(isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

