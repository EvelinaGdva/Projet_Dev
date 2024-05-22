<?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="options text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="restaurants.php">
                    <img src="Images/restaurant.png" alt="Restaurants" class="img-responsive img-curve">
                    <h3>Restaurants</h3>
                </a>
            </div>
            <div class="col-md-4">
                <a href="order.php">
                    <img src="Images/order.png" alt="Order" class="img-responsive img-curve">
                    <h3>Order</h3>
                </a>
            </div>
            <div class="col-md-4">
                <a href="delivery.php">
                    <img src="Images/delivery.png" alt="Delivery" class="img-responsive img-curve">
                    <h3>Delivery</h3>
                </a>
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

<section class="categories">
    <div class="container">
        <?php 
            $sql = "SELECT * FROM category";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food_name = $row['food_name'];
                    $food_description = $row['food_description'];
                    $food_price = $row['food_price'];
                    $image = $row['image'];
                    
                    echo "<div class='box-3 float-container'>";
                    echo "<img src='Images/category/Italian.png' alt='$food_name' class='img-responsive img-curve'>";
                    echo "<h3 class='float-text text-white'>$food_name</h3>";
                    echo "</div>";
                }
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <?php 
            $sql = "SELECT * FROM category";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food_name = $row['food_name'];
                    $food_description = $row['food_description'];
                    $food_price = $row['food_price'];
                    $image = $row['image'];
                    
                    echo "<div class='food-menu-box'>";
                    echo "<div class='food-menu-img'>";
                    if($image == "") {
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        echo "<img src='Images/food/$image' alt='$food_name' class='img-responsive img-curve'>";
                    }
                    echo "</div>";
                    echo "<div class='food-menu-desc'>";
                    echo "<h4>$food_name</h4>";
                    echo "<p class='food-price'>$food_price</p>";
                    echo "<p class='food-detail'>$food_description</p>";
                    echo "<br>";
                    echo "<a href='order.php' class='btn btn-primary'>Order Now</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
