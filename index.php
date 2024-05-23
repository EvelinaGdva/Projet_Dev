<?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<?php 
    if(isset($_SESSION['order']))
    {
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

            if($count > 0)
            {
                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $food_name = $row['food_name'];
                    $food_description = $row['food_description'];
                    $food_price = $row['food_price'];
                    $image = $row['image'];
                    
                    echo "<div class='box-3 float-container'>";
                    echo "<img src='images/category/Italian.png' alt='Pizza' class='img-responsive img-curve'>";
                    echo "<h3 class='float-text text-white'>$food_name</h3>";
                    echo "</div>";
                }
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<section class="restaurants">
    <div class="container">
        <h2 class="text-center">Restaurants</h2>
        
        <?php 
            // Nouvelle requête SQL pour récupérer les restaurants
            $restaurant = "SELECT * FROM restaurant";
            $res_restaurants = mysqli_query($conn, $restaurant);
            $count_restaurants = mysqli_num_rows($res_restaurants);

            if($count_restaurants > 0)
            {
                while($row = mysqli_fetch_assoc($res_restaurants))
                {
                    $restaurant_id = $row['id'];
                    $restaurant_name = $row['name'];
                    $adress = $row['adress'];
                    $restaurant_image = $row['image'];
                    
                    echo "<div class='restaurant-box'>";
                    echo "<div class='restaurant-img'>";
                    if($restaurant_image == "") {
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        echo "<a href='restaurant.php?id=$restaurant_id'><img src='images/restaurants/$restaurant_image' alt='$restaurant_name' class='img-responsive img-curve'></a>";
                    }
                    echo "</div>";
                    echo "<div class='restaurant-desc'>";
                    echo "<h4>$restaurant_name</h4>";
                    echo "<p class='restaurant-detail'>$adress</p>";
                    echo "<br>";
                    echo "<a href='restaurant.php?id=$restaurant_id' class='btn btn-primary'>View Details</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            else
            {
                echo "<div class='error'>No restaurants found.</div>";
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

            if($count > 0)
            {
                while($row = mysqli_fetch_assoc($res))
                {
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
                        echo "<img src='Images/food/food.jpg' alt='Pizza' class='img-responsive img-curve'>";
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
