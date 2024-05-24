<?php include('menu-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Cherchez..." required>
            <input type="submit" name="submit" value=" " class="btn btn-primary">
        </form>
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
                    $restaurant_name = $row['restaurant_name'];
                    $adress = $row['adress'];
                    $restaurant_image = $row['logo'];
                        
                    
                    echo "<div class='restaurant-box'>";
                    echo "<div class='restaurant-img'>";
                    if($restaurant_image == "") {
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        echo "<a href='restaurant.php?id=$restaurant_id'><img src='Images/$restaurant_image' alt='$restaurant_name' class='img-responsive img-curve'></a>";
                    }
                    echo "</div>";
                    echo "<div class='restaurant-desc'>";
                    echo "<h4>$restaurant_name</h4>";
                    echo "<p class='restaurant-detail'>$adress</p>";
                    echo "<br>";
                    echo "<a href='food.php?id=$restaurant_id' class='btn btn-primary'>Voir les plats</a>";
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

